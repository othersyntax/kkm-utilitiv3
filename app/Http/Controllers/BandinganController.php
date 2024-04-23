<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fasiliti;

class BandinganController extends Controller
{
    public function index(){
        $fasiliti = DB::table('tblfasiliti')
                    ->leftJoin('ddsa_kod_negeri', 'tblfasiliti.fas_negeri_id', 'ddsa_kod_negeri.neg_kod_negeri')
                    ->leftJoin('tblfasiliti_kategori', 'tblfasiliti.fas_kat_kod', 'tblfasiliti_kategori.faskat_kod')
                    ->select('tblfasiliti.fasiliti_id', 'tblfasiliti.fas_name', 'ddsa_kod_negeri.neg_nama_negeri', 'tblfasiliti_kategori.faskat_desc')
                    ->orderBy('ddsa_kod_negeri.neg_nama_negeri')
                    ->get();
        return view('dashboard.bandingan', compact('fasiliti'));
    }

    public function getDataBandingan(Request $req){
        // dd($req);
        $listID = $req->fasSelectID;
        $a = implode(",",$listID);
        $dataBanding=DB::select('select
                                fas_name,
                                SUM(if(tblutiliti.uti_bulan = 1, uti_amaun, 0)) as Jan,
                                SUM(if(tblutiliti.uti_bulan = 2, uti_amaun, 0)) as Feb,
                                SUM(if(tblutiliti.uti_bulan = 3, uti_amaun, 0)) as Mac,
                                SUM(if(tblutiliti.uti_bulan = 4, uti_amaun, 0)) as Apr,
                                SUM(if(tblutiliti.uti_bulan = 5, uti_amaun, 0)) as Mei,
                                SUM(if(tblutiliti.uti_bulan = 6, uti_amaun, 0)) as Jun,
                                SUM(if(tblutiliti.uti_bulan = 7, uti_amaun, 0)) as Jul,
                                SUM(if(tblutiliti.uti_bulan = 8, uti_amaun, 0)) as Ogo,
                                SUM(if(tblutiliti.uti_bulan = 9, uti_amaun, 0)) as Sep,
                                SUM(if(tblutiliti.uti_bulan = 10, uti_amaun, 0))as Okt,
                                SUM(if(tblutiliti.uti_bulan = 11, uti_amaun, 0)) as Nov,
                                SUM(if(tblutiliti.uti_bulan = 12, uti_amaun, 0)) as Dis
                                from
                                tblutiliti
                                left join tblfasiliti on tblutiliti.uti_fasiliti_id = tblfasiliti.fas_ptj_code
                                left join ddsa_kod_negeri on tblfasiliti.fas_negeri_id = ddsa_kod_negeri.neg_kod_negeri
                                where
                                fasiliti_id in ('.$a.')
                                group by fas_name');
        // dd( $dataBanding);
        //uti_tahun = 2022 AND
        echo json_encode($dataBanding);

    }
}
