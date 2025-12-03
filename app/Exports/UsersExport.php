<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $type;

    public function __construct($type = 'all')
    {
        $this->type = $type;
    }

    public function collection()
    {
        if ($this->type === 'trash') {
            return User::onlyTrashed()->latest()->get();
        }

        return User::latest()->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'ID USER',
            'NAMA LENGKAP',
            'EMAIL',
            'JENIS KELAMIN',
            'ALAMAT',
            'ROLE',
            'POINT EARNED',
            'TANGGAL DIBUAT',
            'TANGGAL DIPERBARUI',
            'STATUS'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            'USR' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
            $user->name,
            $user->email,
            $user->JK ?? 'Belum diisi',
            $user->alamat ?? 'Belum diisi',
            strtoupper($user->role),
            $user->points ?? 0,
            $user->created_at->format('d/m/Y'),
            $user->updated_at->format('d/m/Y'),
            $user->deleted_at ? 'DIHAPUS' : 'AKTIF'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header (baris pertama)
        $sheet->getStyle('A1:K1')->applyFromArray([
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
        $sheet->getStyle('A2:K1000')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['rgb' => 'DDDDDD']
                ]
            ]
        ]);

        // Auto size columns
        foreach(range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }

    public function title(): string
    {
        return $this->type === 'trash' ? 'Users Terhapus' : 'Data Users';
    }
}
