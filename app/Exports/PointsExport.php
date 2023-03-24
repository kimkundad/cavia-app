<?php

namespace App\Exports;

use App\Models\point;
use Maatwebsite\Excel\Concerns\FromCollection;

class PointsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return point::all();
    }
}
