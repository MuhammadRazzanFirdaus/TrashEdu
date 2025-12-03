<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArticlesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $type;

    public function __construct($type = 'all')
    {
        $this->type = $type;
    }

    public function collection()
    {
        if ($this->type === 'trash') {
            return Article::onlyTrashed()->latest()->get();
        }

        return Article::latest()->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'ID ARTIKEL',
            'JUDUL ARTIKEL',
            'KONTEN',
            'TANGGAL DIBUAT',
            'TANGGAL DIPERBARUI',
            'STATUS'
        ];
    }

    public function map($article): array
    {
        return [
            $article->id,
            'ART' . str_pad($article->id, 4, '0', STR_PAD_LEFT),
            $article->title,
            strip_tags($article->content),
            $article->created_at->format('d/m/Y'),
            $article->updated_at->format('d/m/Y'),
            $article->deleted_at ? 'DIHAPUS' : 'AKTIF'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header (baris pertama)
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '3498DB']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        $sheet->getStyle('A2:G1000')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ]);

        foreach(range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }

    public function title(): string
    {
        return $this->type === 'trash' ? 'Artikel Terhapus' : 'Data Artikel';
    }
}
