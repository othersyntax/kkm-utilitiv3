<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Utiliti;
use App\Models\Negeri;
use Carbon\Carbon;
use DB;

class DashboardkkmController extends Controller
{
    // CONST $nilai = 30000000;
    function index(Request $req){
        $where = '';
        $where1 = '';
        $year= '';
        if ($req->isMethod('post') || $req->has('negeri')){  
            $selKategori = $req->kategori;          
            $selNegeri = $req->negeri;          
            if($req->kategori != ''){
                $where .= " and fas_kat_kod = '".$req->kategori."'";
                session(['kategori'=> $req->kategori]);
            }
            else{
                session()->forget(['kategori']); 
            }

            if($req->negeri != ''){
                $where .= ' and neg_kod_negeri= '.$req->negeri;
                $where1 = ' where neg_kod_negeri= '.$req->negeri;
                session(['negeri'=> $req->negeri]);
            }
            else{
                session()->forget(['negeri']); 
            }
            
            if($req->tahun != ''){
                $year=' AND uti_tahun='.$req->tahun;
                session(['tahun'=> $req->tahun]);
            }
            else{
                session()->forget(['tahun']); 
            }
            // dd($req->all());
        }
        else{
            session()->forget(['kategori', 'negeri', 'tahun']);
        }

        // $lsnegeri = Negeri::select('neg_kod_negeri', 'neg_nama_negeri')->where('neg_status', 1)->orderBy('neg_nama_negeri')->get();

        $statedata=DB::select('select
                                neg_kod_negeri,
                                neg_nama_negeri,
                                SUM(if(uti_type=1,uti_amaun,0)) as eletrik,
                                SUM(if(uti_type=2,uti_amaun,0)) as air,
                                SUM(if(uti_type=3,uti_amaun,0)) as telefon
                                from
                                tblutiliti
                                INNER JOIN tblfasiliti ON uti_fasiliti_id = fas_ptj_code
                                INNER JOIN ddsa_kod_negeri ON fas_negeri_id = neg_kod_negeri
                                WHERE
                                1=1 '.$year.' GROUP BY neg_kod_negeri, neg_nama_negeri');
        
 
            
        $jumlah=DB::select('select 
                            neg_kod_negeri, 
                            SUM(if(uti_type=1, uti_amaun, 0)) AS eletrik, 
                            SUM(if(uti_type=2, uti_amaun, 0)) AS air,
                            SUM(if(uti_type=3, uti_amaun, 0)) AS telefon
                            FROM
                            tblutiliti
                            INNER JOIN tblfasiliti ON uti_fasiliti_id = fas_ptj_code
                            INNER JOIN ddsa_kod_negeri ON fas_negeri_id = neg_kod_negeri
                            WHERE
                            1=1 '.$year.' '.$where.'
                            GROUP BY neg_kod_negeri');

        $maps=DB::select('select
                            neg_kod_negeri,
                            neg_maps_code,
                            neg_nama_negeri,
                            SUM(uti_amaun) as amaun
                            FROM
                            tblutiliti
                            INNER JOIN tblfasiliti ON uti_fasiliti_id = fas_ptj_code
                            INNER JOIN ddsa_kod_negeri ON fas_negeri_id = neg_kod_negeri
                            where
                            1=1 '.$year.' '.$where.'
                            GROUP BY neg_kod_negeri, neg_maps_code, neg_nama_negeri');
   
        $tahunan=DB::select('select uti_tahun as tahun, SUM(uti_amaun) as amaun FROM
                            tblutiliti 
                            INNER JOIN tblfasiliti ON uti_fasiliti_id = fas_ptj_code
                            INNER JOIN ddsa_kod_negeri ON fas_negeri_id = neg_kod_negeri
                            '.$where1 .'
                            GROUP BY tahun');
        //Jika ada state :  //  WHERE      ddsa_kod_negeri.neg_kod_negeri = 13  
        
        $fasiliti=DB::select('select
                                fasiliti_id,
                                fas_name,
                                SUM(uti_amaun) as amaun
                                FROM
                                tblutiliti
                                INNER JOIN tblfasiliti ON uti_fasiliti_id = fas_ptj_code
                                INNER JOIN ddsa_kod_negeri ON fas_negeri_id = neg_kod_negeri
                                WHERE
                                1=1 '.$year.' ' .$where.'
                                GROUP BY fasiliti_id, fas_name ORDER BY amaun DESC');

        //Barchart
       
        $barData=DB::select('select
                                tblutiliti.uti_bulan as Bulan,
                                SUM(if(uti_type=1, uti_amaun, 0)) AS Elektrik, 
                                SUM(if(uti_type=2, uti_amaun, 0)) AS Air,
                                SUM(if(uti_type=3, uti_amaun, 0)) AS Telefon 
                                FROM
                                tblutiliti
                                INNER JOIN tblfasiliti ON tblutiliti.uti_fasiliti_id = tblfasiliti.fas_ptj_code
                                INNER JOIN ddsa_kod_negeri ON fas_negeri_id = neg_kod_negeri
                                where 
                                1=1 '.$year.' ' .$where.'
                                GROUP BY Bulan 
                                ORDER BY CAST(Bulan AS UNSIGNED) asc');
                                // jika nak 6 bulan shj AND uti_bulan >= MONTH(CURDATE() - interval 5 month)
        
        $result[] = ['Bulan','Elektrik','Air', 'Telefon'];
        foreach ($barData as $key => $value) {
            $result[++$key] = [$this->tukarBulan($value->Bulan), (double)$value->Elektrik, (double)$value->Air, (double)$value->Telefon];
        }
        // $barchart = json_encode($result);


        $mapnegeri[] = ['Negeri', 'Amaun (RM)'];
        foreach($maps as $key=>$value){
            $mapnegeri[] = [array('v'=>$value->neg_maps_code, 'f'=>$value->neg_nama_negeri), (double)$value->amaun];
        }


        $eletrik=0;
        $air=0;
        $telefon=0;
        foreach($jumlah as $jum){
            $eletrik += $jum->eletrik;
            $air += $jum->air;
            $telefon += $jum->telefon;
        }

        $data['eletrik'] = $eletrik;
        $data['air'] = $air;
        $data['telefon'] = $telefon;
        $data['fasiliti'] = $fasiliti;
        $data['tahunan'] = $tahunan;
        $data['negeri'] = $mapnegeri;
        $data['barchart'] = $result;
        $data['statedata'] = $statedata;

        // dd($data);
        // dd($mapnegeri);
        return view('dashboard.dashboard', $data);
    }

    function tukarBulan($bln){
        if($bln==1)
            return 'Jan';
        else if($bln==2)
            return 'Feb';
        else if($bln==3)
            return 'Mac';
        else if($bln==4)
            return 'Apr';
        else if($bln==5)
            return 'Mei';
        else if($bln==6)
            return 'Jun';
        else if($bln==7)
            return 'Jul';
        else if($bln==8)
            return 'Ogo';
        else if($bln==9)
            return 'Sep';
        else if($bln==10)
            return 'Okt';
        else if($bln==11)
            return 'Nov';
        else
            return 'Dis';
    }

    function ajaxFasiliti(Request $req){
        $where ='';
        $fasiliti_id = $req->fasiliti_id;
        $tahun = $req->tahun;
        if($tahun != '' || !empty($tahun)){
            $where = " AND uti_tahun= ". $tahun;
        }

        $datahospital=DB::select('select 
                                    uti_bulan AS Bulan, 
                                    SUM(if(uti_type=1, uti_amaun, 0)) AS Elektrik, 
                                    SUM(if(uti_type=2, uti_amaun, 0)) AS Air,
                                    SUM(if(uti_type=3, uti_amaun, 0)) AS Telefon
                                    from `tblutiliti`
                                    INNER JOIN tblfasiliti ON uti_fasiliti_id = fas_ptj_code
                                    INNER JOIN ddsa_kod_negeri ON fas_negeri_id = neg_kod_negeri
                                    WHERE 
                                    fasiliti_id = '.$fasiliti_id.' '.$where.'
                                    GROUP BY Bulan 
                                    ORDER BY CAST(Bulan AS UNSIGNED) asc');
        echo json_encode($datahospital);
    }
}
