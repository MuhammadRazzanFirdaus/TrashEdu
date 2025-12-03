<?php

namespace App\Exports;

use App\Models\Quiz;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuizzesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $type;

    public function __construct($type = 'all')
    {
        $this->type = $type;
    }

    public function collection()
    {
        if ($this->type === 'trash') {
            return Quiz::onlyTrashed()->withCount('questions')->latest()->get();
        }

        return Quiz::withCount('questions')->latest()->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'ID QUIZ',
            'JUDUL QUIZ',
            'DESKRIPSI',
            'JUMLAH SOAL',
            'REWARD POINT',
            'STATUS AKTIF',
            'TANGGAL DIBUAT',
            'TANGGAL DIPERBARUI',
            'STATUS'
        ];
    }

    public function map($quiz): array
    {
        return [
            $quiz->id,
            'QUIZ' . str_pad($quiz->id, 4, '0', STR_PAD_LEFT),
            $quiz->title,
            $quiz->description ?? '-',
            $quiz->questions_count . ' Soal',
            $quiz->point_reward . ' Point',
            $quiz->is_active ? 'AKTIF' : 'NONAKTIF',
            $quiz->created_at->format('d/m/Y'),
            $quiz->updated_at->format('d/m/Y'),
            $quiz->deleted_at ? 'DIHAPUS' : 'AKTIF'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header (baris pertama)
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '28a745'] // Hijau sesuai theme
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Style untuk data
        $sheet->getStyle('A2:J1000')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ]);

        // Auto size columns
        foreach(range('A', 'J') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }

    public function title(): string
    {
        return $this->type === 'trash' ? 'Quizzes Terhapus' : 'Data Quizzes';
    }
}
