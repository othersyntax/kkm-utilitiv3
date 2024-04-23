<?php
use App\Models\Kategori;
use App\Models\Negeri;

function dropdownKategori(){
    $kat = Kategori::where('faskat_status', '=', 1)
                ->pluck('faskat_desc', 'faskat_kod')
                ->prepend('--Pilih Kategori--', '');
    
    return $kat;
}

function dropdownNegeri(){
    $negeri = Negeri::orderBy('neg_nama_negeri')
        ->pluck('neg_nama_negeri','neg_kod_negeri')
        ->prepend('--Pilih Negeri--',  '');
    // dd($negeri);
    return $negeri;
}

function dropdownYear(){
    $years['']="Tahun";
    $curr_y = date('Y');
    $until_y = $curr_y - 5;
    for($year = $curr_y; $year > $until_y; $year--){
        $years[$year] = $year;
    }

    return $years;
}

function getNegeri($kod){
    if($kod=='01')
        return 'JOHOR';
    else if($kod=='02')
        return 'KEDAH';
    else if($kod=='03')
        return 'KELANTAN';
    else if($kod=='04')
        return 'MELAKA';
    else if($kod=='05')
        return 'NEGERI SEMBILAN';
    else if($kod=='06')
        return 'PAHANG';
    else if($kod=='07')
        return 'PUAU PINANG';
    else if($kod=='08')
        return 'PERAK';
    else if($kod=='09')
        return 'PERLIS';
    else if($kod=='10')
        return 'SELANGOR';
    else if($kod=='11')
        return 'TERENGGANU';
    else if($kod=='12')
        return 'SABAH';
    else if($kod=='13')
        return 'SARAWAK';
    else if($kod=='14')
        return 'W.P. KUALA LUMPUR';
    else if($kod=='15')
        return 'W.P. LABUAN';
    else
        return 'W.P. PUTRAJAYA';
}