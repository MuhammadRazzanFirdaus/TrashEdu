<?php

namespace App\Exports;

use App\Models\Reward;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RewardsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Reward::all(['id','name','description','points_required','stock']);
    }

    public function headings(): array
    {
        return ['ID','Nama','Deskripsi','Point Required','Stock'];
    }
}
