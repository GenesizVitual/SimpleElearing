<?php

namespace App\Exports;

use App\Model\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiswaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Siswa::all();
    }
}
