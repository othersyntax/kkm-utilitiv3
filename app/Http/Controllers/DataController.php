<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utiliti;
use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function index(){
        $sesi= date('dmY');
        // dd($sesi);
        $data = Utiliti::where('uti_session', $sesi)->paginate(20);
        return view('pentadbir.data.index', compact('data'));
    }

    public function ajaxAll($sesi){
        $data = Utiliti::where('uti_session', $sesi)->paginate(20);
        // dd($data);
        return response()->json([
            'data'=>$data,
        ]);
    }

    public function muatnaik(Request $req){
        $data = $req->file('failExcel');

        $validator = Validator::make($req->all(), [
            'failExcel'=> 'required|mimes:xlsx',
        ],
        [
            'failExcel.required'=> 'Sila pilih fail Ms Excel',
            'failExcel.mimes'=> 'Hanya fail Ms Excel sahaja dibenarakan',
        ]);

        if($validator->fails())
        {
            return redirect('/pentadbir/data/senarai')->with('msg', 'Terdapat kesilapan pada fail');
            // return response()->json([
            //     'status'=>400,
                
            // ]);
        }
        else{
            $namaFail = $data->getClientOriginalName();
            $data->move('DataExcel', $namaFail);
            Excel::import(new DataImport, \public_path('/DataExcel/'.$namaFail));
            return redirect('/pentadbir/data/senarai')->with('msg','Data Berjaya dimuat naik');
        }  

        // if (empty($req->file('failExcel')->getRealPath())) 
    }
}
