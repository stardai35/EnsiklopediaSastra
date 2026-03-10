<?php

namespace App\Exports;

use App\Models\Content;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class ContentTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths, WithTitle, WithEvents
{
    public function array(): array
    {
        $contents = Content::with(['category', 'lemma', 'media'])
            ->orderBy('id')
            ->limit(5)
            ->get();

        if ($contents->isEmpty()) {
            return [
                ['', '', '', '', '', ''],
            ];
        }

        return $contents->map(function (Content $content) {
            $images = $content->media
                ->sortBy('position_id')
                ->values();

            $imageUrls = $images
                ->pluck('image_url')
                ->filter()
                ->implode("\n");

            $captions = $images
                ->pluck('caption')
                ->filter(function ($caption) {
                    return filled($caption);
                })
                ->implode("\n");

            return [
                $content->category?->name ?? '',
                $content->lemma?->name ?? ($content->title ?? ''),
                $content->year ?? '',
                $content->text ?? '',
                $imageUrls,
                $captions,
            ];
        })->toArray();
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Lemma/Judul', 
            'Tahun',
            'Konten',
            'URL Gambar',
            'Caption Gambar'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        return [
            // Style the header row
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                $sheet->freezePane('A2');
                $sheet->setAutoFilter('A1:F1');
                $sheet->getRowDimension(1)->setRowHeight(24);

                $sheet->getStyle('A1:F' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle('A2:F' . $highestRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                $sheet->getStyle('A2:F' . $highestRow)->getAlignment()->setWrapText(true);
                $sheet->getStyle('C2:C' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                for ($row = 2; $row <= $highestRow; $row++) {
                    // Auto-fit row height based on wrapped text content.
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,  // Kategori
            'B' => 30,  // Lemma/Judul
            'C' => 15,  // Tahun
            'D' => 60,  // Konten
            'E' => 40,  // URL Gambar
            'F' => 30,  // Caption Gambar
        ];
    }

    public function title(): string
    {
        return 'Template Konten';
    }
}
