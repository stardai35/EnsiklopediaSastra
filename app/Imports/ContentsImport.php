<?php

namespace App\Imports;

use App\Models\Content;
use App\Models\Category;
use App\Models\Lemma;
use App\Models\Media;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;

class ContentsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsFailures;

    protected $importedCount = 0;
    protected $skippedCount = 0;
    protected $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                $kategori = trim((string) $this->getRowValue($row, ['kategori', 'category']));
                $konten = trim((string) $this->getRowValue($row, ['konten', 'text']));
                $konten = $this->formatContentFromExcel($konten);

                // Resolve category from ID or category name.
                $category = $this->resolveCategory($row, $kategori);

                // Resolve lemma from ID or name to match separate lemma table structure.
                $lemma = $this->resolveLemma($row);
                $lemmaName = trim((string) ($lemma->name ?? ''));

                // Create slug
                $slug = Str::slug($lemmaName);
                $slugCount = Content::where('slug', 'like', $slug . '%')->count();
                if ($slugCount > 0) {
                    $slug = $slug . '-' . ($slugCount + 1);
                }

                // Create content
                $content = Content::create([
                    'cat_id' => $category->id,
                    'title_id' => $lemma->id,
                    'year' => $this->getRowValue($row, ['tahun', 'year']),
                    'text' => $konten,
                    'slug' => $slug
                ]);

                // Handle images if provided
                if (filled($this->getRowValue($row, ['url_gambar', 'urlgambar', 'image_url', 'url']))) {
                    $this->processImages($content, $row);
                }

                $this->importedCount++;
            } catch (\Exception $e) {
                $this->skippedCount++;
                $this->errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
            }
        }
    }

    /**
     * Process and download images from URLs
     */
    protected function processImages(Content $content, $row)
    {
        // Get image URLs - recommended separator: semicolon or newline.
        $imageUrls = (string) $this->getRowValue($row, ['url_gambar', 'urlgambar', 'image_url', 'url']);
        $urls = preg_split('/[;\r\n]+/', $imageUrls, -1, PREG_SPLIT_NO_EMPTY);
        
        // Get captions if provided - same separation
        $captions = [];
        $captionText = (string) $this->getRowValue($row, ['caption_gambar', 'captiongambar', 'caption']);
        if (filled($captionText)) {
            $captions = preg_split('/[;\r\n]+/', $captionText, -1, PREG_SPLIT_NO_EMPTY);
        }

        $position = $content->media()->max('position_id') ?? 0;

        foreach ($urls as $index => $url) {
            $url = trim((string) $url, " \t\n\r\0\x0B\"'");
            
            if (empty($url)) {
                continue;
            }

            try {
                // Check if URL is valid
                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    \Log::warning("Invalid image URL", [
                        'content_id' => $content->id,
                        'url' => $url
                    ]);
                    continue;
                }

                // Download image from URL
                $response = Http::timeout(30)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36',
                        'Accept' => 'image/*,*/*;q=0.8',
                    ])
                    ->get($url);
                
                if ($response->successful()) {
                    $imageContent = $response->body();
                    
                    // Get file extension from URL or content type
                    $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
                    if (empty($extension)) {
                        $contentType = $response->header('Content-Type');
                        $extension = $this->getExtensionFromMimeType($contentType);
                    }
                    
                    // Generate unique filename
                    $filename = 'content_' . $content->id . '_' . time() . '_' . $index . '.' . $extension;
                    $path = 'contents/' . $filename;
                    
                    // Save to storage
                    Storage::disk('public')->put($path, $imageContent);
                    
                    // Create media record
                    $position++;
                    Media::create([
                        'type_id' => 1, // Image type
                        'content_id' => $content->id,
                        'position_id' => $position,
                        'link' => $path,
                        'caption' => $captions[$index] ?? '',
                    ]);
                    
                    \Log::info("Image downloaded successfully", [
                        'content_id' => $content->id,
                        'url' => $url,
                        'path' => $path
                    ]);
                } else {
                    \Log::warning("Failed to download image", [
                        'content_id' => $content->id,
                        'url' => $url,
                        'status' => $response->status()
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error("Error processing image", [
                    'content_id' => $content->id,
                    'url' => $url,
                    'error' => $e->getMessage()
                ]);
            }
        }
    }

    /**
     * Get file extension from MIME type
     */
    protected function getExtensionFromMimeType($mimeType)
    {
        $mimeMap = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
        ];

        return $mimeMap[$mimeType] ?? 'jpg';
    }

    public function rules(): array
    {
        return [
            'kategori' => 'required_without_all:category,cat_id|string',
            'category' => 'nullable|string',
            'cat_id' => 'nullable|integer|exists:category,id',
            'lemma_judul' => 'required_without_all:lemma,judul,lemma_id,lemmajudul|string',
            'lemma' => 'nullable|string',
            'judul' => 'nullable|string',
            'lemmajudul' => 'nullable|string',
            'lemma_id' => 'nullable|integer|exists:lemma,id',
            'konten' => 'required_without:text|string',
            'text' => 'nullable|string',
            'tahun' => 'nullable|string',
            'year' => 'nullable|string',
            'url_gambar' => 'nullable|string',
            'caption_gambar' => 'nullable|string'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'kategori.required' => 'Kolom Kategori wajib diisi.',
            'kategori.required_without_all' => 'Kolom Kategori wajib diisi (atau isi Category/Cat ID).',
            'cat_id.exists' => 'Cat ID tidak ditemukan di tabel category.',
            'lemma_judul.required_without_all' => 'Kolom Lemma/Judul wajib diisi (atau isi Lemma, Judul, atau Lemma ID).',
            'lemma_id.exists' => 'Lemma ID tidak ditemukan di tabel lemma.',
            'konten.required_without' => 'Kolom Konten wajib diisi.',
        ];
    }

    protected function resolveCategory($row, string $kategori): Category
    {
        $catId = $this->getRowValue($row, ['cat_id']);
        if (filled($catId)) {
            $category = Category::find((int) $catId);
            if ($category) {
                return $category;
            }
        }

        if ($kategori === '') {
            throw new \Exception('Kolom Kategori wajib diisi.');
        }

        return Category::firstOrCreate(
            ['name' => $kategori],
            ['slug' => Str::slug($kategori)]
        );
    }

    protected function resolveLemma($row): Lemma
    {
        $lemmaId = $this->getRowValue($row, ['lemma_id']);
        if (filled($lemmaId)) {
            $lemma = Lemma::find((int) $lemmaId);
            if ($lemma) {
                return $lemma;
            }
        }

        $lemmaName = trim((string) $this->getRowValue($row, ['lemma_judul', 'lemmajudul', 'lemma', 'judul']));
        if ($lemmaName === '') {
            throw new \Exception('Kolom Lemma/Judul wajib diisi.');
        }

        return Lemma::firstOrCreate(['name' => $lemmaName], ['name' => $lemmaName]);
    }

    protected function getRowValue($row, array $keys)
    {
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            if (!is_string($key)) {
                continue;
            }
            $normalizedRow[$this->normalizeKey($key)] = $value;
        }

        foreach ($keys as $key) {
            if (isset($row[$key]) && filled($row[$key])) {
                return $row[$key];
            }

            $normalizedKey = $this->normalizeKey($key);
            if (array_key_exists($normalizedKey, $normalizedRow) && filled($normalizedRow[$normalizedKey])) {
                return $normalizedRow[$normalizedKey];
            }
        }

        return null;
    }

    protected function normalizeKey(string $key): string
    {
        return preg_replace('/[^a-z0-9]/', '', strtolower($key));
    }

    protected function formatContentFromExcel(string $text): string
    {
        if ($text === '') {
            return $text;
        }

        // Keep existing HTML content as-is when admin already supplies HTML in Excel cell.
        if ($this->containsHtml($text)) {
            return $text;
        }

        $normalized = str_replace(["\r\n", "\r"], "\n", $text);

        // Support lightweight formatting markers from plain Excel text input.
        $normalized = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $normalized);
        $normalized = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $normalized);
        $normalized = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $normalized);
        $normalized = preg_replace('/_(.+?)_/s', '<em>$1</em>', $normalized);

        // Preserve manual Enter (Alt+Enter) from Excel as line breaks in HTML rendering.
        return nl2br($normalized);
    }

    protected function containsHtml(string $text): bool
    {
        return preg_match('/<\s*\/?\s*[a-z][^>]*>/i', $text) === 1;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = "Baris " . $failure->row() . ": " . implode(', ', $failure->errors());
        }
    }
}
