<?php

namespace App\Imports;

use App\Model\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return  Siswa::firstOrCreate(
            [
                'kode'     => $row[1]
            ],
            [
                'password'    => bcrypt($row[2]),
                'see_password' => $row[2],
                'nama' => $row[3],
                'kelas' => $row[4],
                'label_kelas' => $row[5],
                'jenis_kelas' => $row[6],
                'angkatan' => $row[7],
            ]
        );
    }

    public function startRow(): int
    {
        return 2;
    }
}
