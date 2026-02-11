<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use App\Models\Lemma;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function dashboard(): View
    {
        $totalContents = Content::count();
        $totalCategories = Category::count();
        $recentContents = Content::with('lemma', 'category', 'media')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalContents' => $totalContents,
            'totalCategories' => $totalCategories,
            'recentContents' => $recentContents,
        ]);
    }

    public function index(Request $request): View
    {
        $query = Content::with('category', 'lemma', 'media');
        $categories = Category::all();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('cat_id', $request->category);
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('lemma', function($lemmaQuery) use ($search) {
                      $lemmaQuery->where('name', 'like', '%' . $search . '%');
                  })
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Sort
        $sortBy = $request->input('sort', 'newest');
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'title_az':
                $query->join('lemma', 'content.title_id', '=', 'lemma.id')
                      ->orderBy('lemma.name', 'asc')
                      ->select('content.*');
                break;
            case 'title_za':
                $query->join('lemma', 'content.title_id', '=', 'lemma.id')
                      ->orderBy('lemma.name', 'desc')
                      ->select('content.*');
                break;
            case 'newest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $contents = $query->paginate(15);
        
        return view('admin.contents.index', [
            'contents' => $contents,
            'categories' => $categories,
            'selectedCategory' => $request->category,
            'searchQuery' => $request->search,
            'sortBy' => $sortBy,
        ]);
    }

    public function create(): View
    {
        $categories = Category::all();
        
        return view('admin.contents.create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'lemma_name' => 'required|string|max:255',
            'year' => 'nullable|string|max:50',
            'text' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480', // 20MB
            'image_captions.*' => 'nullable|string|max:255',
        ]);

        // Find or create lemma
        $lemma = Lemma::firstOrCreate(
            ['name' => $validated['lemma_name']],
            ['name' => $validated['lemma_name']]
        );

        $validated['title_id'] = $lemma->id;
        $validated['slug'] = Str::slug($validated['lemma_name']);
        unset($validated['lemma_name']);

        // Create content
        $content = Content::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $captions = $request->input('image_captions', []);
            $maxPosition = $content->media()->max('position_id') ?? 0;
            
            \Log::info('Image upload started', [
                'content_id' => $content->id,
                'image_count' => count($images),
                'captions_count' => count($captions)
            ]);
            
            foreach ($images as $index => $image) {
                // Filter out empty file inputs
                if ($image && $image->isValid() && $image->getSize() > 0) {
                    try {
                        \Log::info('Processing image', [
                            'content_id' => $content->id,
                            'index' => $index,
                            'file_name' => $image->getClientOriginalName(),
                            'file_size' => $image->getSize(),
                            'mime_type' => $image->getMimeType()
                        ]);
                        
                        $path = $image->store('contents', 'public');
                        $caption = $captions[$index] ?? '';
                        
                        \Log::info('Image stored successfully', [
                            'content_id' => $content->id,
                            'storage_path' => $path,
                            'caption' => $caption
                        ]);
                        
                        $maxPosition++;
                        $media = Media::create([
                            'type_id' => 1,
                            'content_id' => $content->id,
                            'position_id' => $maxPosition,
                            'link' => $path,
                            'caption' => $caption,
                        ]);
                        
                        \Log::info('Media record created', [
                            'media_id' => $media->id,
                            'content_id' => $content->id,
                            'position_id' => $maxPosition,
                            'link' => $path
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to save image', [
                            'content_id' => $content->id,
                            'index' => $index,
                            'file_name' => $image->getClientOriginalName(),
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                } else {
                    \Log::warning('Skipping invalid or empty image', [
                        'content_id' => $content->id,
                        'index' => $index,
                        'is_valid' => $image ? $image->isValid() : false,
                        'file_size' => $image ? $image->getSize() : 0
                    ]);
                }
            }
            
            \Log::info('Image upload process completed', [
                'content_id' => $content->id
            ]);
        }

        return redirect()->route('admin.contents.index')
            ->with('success', 'Konten berhasil ditambahkan!');
    }

    public function edit(Content $content): View
    {
        $categories = Category::all();
        $content->load('media', 'lemma');
        
        return view('admin.contents.edit', [
            'content' => $content,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        \Log::info('Update method called', [
            'content_id' => $content->id,
            'has_images' => $request->hasFile('images'),
            'images_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
            'all_files' => $request->allFiles()
        ]);

        $validated = $request->validate([
            'cat_id' => 'required|exists:category,id',
            'lemma_name' => 'required|string|max:255',
            'year' => 'nullable|string|max:50',
            'text' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:20480', // 20MB
            'image_captions.*' => 'nullable|string|max:255',
        ]);

        // Find or create lemma
        $lemma = Lemma::firstOrCreate(
            ['name' => $validated['lemma_name']],
            ['name' => $validated['lemma_name']]
        );

        $validated['title_id'] = $lemma->id;
        
        // Generate slug dari lemma name jika ada perubahan
        if ($validated['title_id'] != $content->title_id || $validated['lemma_name'] != $content->lemma->name) {
            $validated['slug'] = Str::slug($validated['lemma_name']);
        }
        
        unset($validated['lemma_name']);

        $content->update($validated);

        // Handle image uploads
        $allFiles = $request->allFiles();
        \Log::info('All files in request', [
            'content_id' => $content->id,
            'all_files_keys' => array_keys($allFiles),
            'has_images' => $request->hasFile('images'),
            'images_in_all_files' => isset($allFiles['images'])
        ]);
        
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $captions = $request->input('image_captions', []);
            $maxPosition = $content->media()->max('position_id') ?? 0;
            
            // Ensure images is an array
            if (!is_array($images)) {
                $images = [$images];
            }
            
            // Filter out null/empty values
            $images = array_filter($images, function($img) {
                return $img !== null && $img->isValid() && $img->getSize() > 0;
            });
            
            \Log::info('Image upload started (Update)', [
                'content_id' => $content->id,
                'image_count_before_filter' => count($request->file('images')),
                'image_count_after_filter' => count($images),
                'captions_count' => count($captions)
            ]);
            
            if (count($images) > 0) {
                // Re-index array to match captions
                $images = array_values($images);
                
                foreach ($images as $index => $image) {
                    try {
                        \Log::info('Processing image (Update)', [
                            'content_id' => $content->id,
                            'index' => $index,
                            'file_name' => $image->getClientOriginalName(),
                            'file_size' => $image->getSize(),
                            'mime_type' => $image->getMimeType()
                        ]);
                        
                        $path = $image->store('contents', 'public');
                        $caption = isset($captions[$index]) ? $captions[$index] : '';
                        
                        \Log::info('Image stored successfully (Update)', [
                            'content_id' => $content->id,
                            'storage_path' => $path,
                            'caption' => $caption
                        ]);
                        
                        $maxPosition++;
                        $media = Media::create([
                            'type_id' => 1,
                            'content_id' => $content->id,
                            'position_id' => $maxPosition,
                            'link' => $path,
                            'caption' => $caption,
                        ]);
                        
                        \Log::info('Media record created (Update)', [
                            'media_id' => $media->id,
                            'content_id' => $content->id,
                            'position_id' => $maxPosition,
                            'link' => $path
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to save image (Update)', [
                            'content_id' => $content->id,
                            'index' => $index,
                            'file_name' => $image->getClientOriginalName(),
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                    }
                }
                
                \Log::info('Image upload process completed (Update)', [
                    'content_id' => $content->id,
                    'images_saved' => count($images)
                ]);
            } else {
                \Log::warning('No valid images found after filtering (Update)', [
                    'content_id' => $content->id
                ]);
            }
        } else {
            \Log::info('No images to upload (Update)', [
                'content_id' => $content->id,
                'has_files' => $request->hasFile('images')
            ]);
        }

        return redirect()->route('admin.contents.index')
            ->with('success', 'Konten berhasil diperbarui!');
    }

    public function destroy(Content $content): RedirectResponse
    {
        \Log::info('Deleting content', [
            'content_id' => $content->id,
            'content_slug' => $content->slug
        ]);

        try {
            // Delete all associated media files and records
            $mediaRecords = $content->media;
            
            \Log::info('Found media records to delete', [
                'content_id' => $content->id,
                'media_count' => $mediaRecords->count()
            ]);

            foreach ($mediaRecords as $media) {
                // Delete file from storage
                if ($media->link && Storage::disk('public')->exists($media->link)) {
                    Storage::disk('public')->delete($media->link);
                    \Log::info('Deleted media file', [
                        'media_id' => $media->id,
                        'file_path' => $media->link
                    ]);
                }
                
                // Delete media record
                $media->delete();
                \Log::info('Deleted media record', [
                    'media_id' => $media->id
                ]);
            }

            // Delete content
            $content->delete();

            \Log::info('Content deleted successfully', [
                'content_id' => $content->id
            ]);

            return redirect()->route('admin.contents.index')
                ->with('success', 'Konten berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete content', [
                'content_id' => $content->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.contents.index')
                ->with('error', 'Gagal menghapus konten: ' . $e->getMessage());
        }
    }

    public function uploadMedia(Request $request, Content $content)
    {
        \Log::info('uploadMedia called', [
            'content_id' => $content->id,
            'has_file' => $request->hasFile('file')
        ]);

        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20480' // 20MB
            ], [
                'file.required' => 'File gambar harus dipilih.',
                'file.image' => 'File harus berupa gambar.',
                'file.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
                'file.max' => 'Ukuran file maksimal 20MB.',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                \Log::info('Processing file upload (Summernote)', [
                    'content_id' => $content->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'is_valid' => $file->isValid()
                ]);
                
                $path = $file->store('contents', 'public');
                
                \Log::info('File stored successfully', [
                    'content_id' => $content->id,
                    'storage_path' => $path
                ]);
                
                $maxPosition = $content->media()->max('position_id') ?? 0;
                $media = Media::create([
                    'type_id' => 1, // Assuming 1 is for images
                    'content_id' => $content->id,
                    'position_id' => $maxPosition + 1,
                    'link' => $path,
                    'caption' => $request->input('caption', ''),
                ]);

                \Log::info('Media record created (Summernote)', [
                    'media_id' => $media->id,
                    'content_id' => $content->id,
                    'position_id' => $maxPosition + 1,
                    'link' => $path,
                    'image_url' => $media->image_url
                ]);

                return response()->json([
                    'success' => true,
                    'media' => $media,
                    'url' => $media->image_url
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed for media upload (Summernote)', [
                'content_id' => $content->id,
                'errors' => $e->errors()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Failed to upload media (Summernote)', [
                'content_id' => $content->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload gambar: ' . $e->getMessage()
            ], 500);
        }

        \Log::warning('Upload failed - no file provided', [
            'content_id' => $content->id
        ]);

        return response()->json([
            'success' => false,
            'message' => 'File tidak ditemukan'
        ], 400);
    }

    public function storeMedia(Request $request, Content $content)
    {
        \Log::info('storeMedia called', [
            'content_id' => $content->id,
            'has_file' => $request->hasFile('file')
        ]);

        $validated = $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20480', // 20MB
            'caption' => 'nullable|string|max:255',
            'position_id' => 'nullable|integer',
        ], [
            'file.required' => 'File gambar harus dipilih.',
            'file.image' => 'File harus berupa gambar.',
            'file.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'file.max' => 'Ukuran file maksimal 20MB.',
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                \Log::info('Processing file upload (Form)', [
                    'content_id' => $content->id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                    'is_valid' => $file->isValid(),
                    'caption' => $validated['caption'] ?? '',
                    'position_id' => $validated['position_id'] ?? null
                ]);
                
                if (!$file->isValid() || $file->getSize() === 0) {
                    \Log::warning('Invalid file provided', [
                        'content_id' => $content->id,
                        'is_valid' => $file->isValid(),
                        'file_size' => $file->getSize()
                    ]);
                    return redirect()->back()
                        ->with('error', 'File gambar tidak valid!');
                }
                
                $path = $file->store('contents', 'public');
                
                \Log::info('File stored successfully (Form)', [
                    'content_id' => $content->id,
                    'storage_path' => $path
                ]);
                
                $maxPosition = $content->media()->max('position_id') ?? 0;
                $media = Media::create([
                    'type_id' => 1,
                    'content_id' => $content->id,
                    'position_id' => $validated['position_id'] ?? ($maxPosition + 1),
                    'link' => $path,
                    'caption' => $validated['caption'] ?? '',
                ]);

                \Log::info('Media record created (Form)', [
                    'media_id' => $media->id,
                    'content_id' => $content->id,
                    'position_id' => $media->position_id,
                    'link' => $path,
                    'caption' => $media->caption
                ]);

                return redirect()->back()
                    ->with('success', 'Gambar berhasil ditambahkan!');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed for media upload (Form)', [
                'content_id' => $content->id,
                'errors' => $e->errors()
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->with('error', 'Validasi gagal: ' . implode(', ', array_flatten($e->errors())));
        } catch (\Exception $e) {
            \Log::error('Failed to store media (Form)', [
                'content_id' => $content->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
        }

        \Log::warning('storeMedia failed - no file provided', [
            'content_id' => $content->id
        ]);

        return redirect()->back()
            ->with('error', 'Gagal mengupload gambar!');
    }

    public function updateMedia(Request $request, Content $content, $mediaId)
    {
        \Log::info('updateMedia called', [
            'content_id' => $content->id,
            'media_id' => $mediaId
        ]);

        try {
            $media = Media::where('id', $mediaId)->where('content_id', $content->id)->firstOrFail();
            
            \Log::info('Media found for update', [
                'media_id' => $media->id,
                'content_id' => $content->id,
                'current_caption' => $media->caption,
                'current_position' => $media->position_id,
                'current_link' => $media->link
            ]);
            
            $validated = $request->validate([
                'caption' => 'nullable|string|max:255',
                'position_id' => 'nullable|integer',
                'link' => 'nullable|string',
            ]);

            \Log::info('Updating media', [
                'media_id' => $media->id,
                'content_id' => $content->id,
                'new_caption' => $validated['caption'] ?? null,
                'new_position' => $validated['position_id'] ?? null,
                'new_link' => $validated['link'] ?? null
            ]);

            $media->update($validated);

            \Log::info('Media updated successfully', [
                'media_id' => $media->id,
                'content_id' => $content->id,
                'updated_fields' => array_keys($validated)
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Gambar berhasil diperbarui!'
                ]);
            }

            return redirect()->back()
                ->with('success', 'Gambar berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Failed to update media', [
                'content_id' => $content->id,
                'media_id' => $mediaId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui gambar'
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui gambar!');
        }
    }

    public function deleteMedia(Request $request, Content $content, $mediaId)
    {
        \Log::info('deleteMedia called', [
            'content_id' => $content->id,
            'media_id' => $mediaId
        ]);

        try {
            $media = Media::where('id', $mediaId)->where('content_id', $content->id)->firstOrFail();
            
            \Log::info('Media found for deletion', [
                'media_id' => $media->id,
                'content_id' => $content->id,
                'link' => $media->link,
                'caption' => $media->caption
            ]);
            
            // Delete file from storage
            if ($media->link && Storage::disk('public')->exists($media->link)) {
                Storage::disk('public')->delete($media->link);
                \Log::info('File deleted from storage', [
                    'media_id' => $media->id,
                    'file_path' => $media->link
                ]);
            } else {
                \Log::warning('File not found in storage or link is empty', [
                    'media_id' => $media->id,
                    'link' => $media->link,
                    'exists' => $media->link ? Storage::disk('public')->exists($media->link) : false
                ]);
            }

            $media->delete();

            \Log::info('Media record deleted successfully', [
                'media_id' => $mediaId,
                'content_id' => $content->id
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Gambar berhasil dihapus!'
                ]);
            }

            return redirect()->back()
                ->with('success', 'Gambar berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete media', [
                'content_id' => $content->id,
                'media_id' => $mediaId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus gambar'
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal menghapus gambar!');
        }
    }
}
