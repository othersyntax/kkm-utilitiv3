<?php

namespace App\Imports;

use App\Models\Utiliti;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class DataImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $sesi = date('dmY');
        // $tarikh = Carbon::createFromFormat('d/m/Y', $row[8])->format('m');
        // dd($tarikh);
        return new Utiliti([
            'uti_session' => $sesi,
            'uti_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('Y-m-d'),
            'uti_bulan' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('m'),
            'uti_amaun' => (float) $row[5],
            'uti_fasiliti_id' => $row[13],
            'uti_tahun' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('Y'),
            'uti_type' => '2'
        ]);
    }
}
