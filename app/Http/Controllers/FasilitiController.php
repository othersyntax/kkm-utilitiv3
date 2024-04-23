<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Fasiliti;


class FasilitiController extends Controller
{
    public function index(){
        return view('pentadbir.fasiliti.index');
    }

    public function ajaxAll(Request $req){
        if($req->isMethod('post')) {
            $carian_type = $req->carian_type;
            $carian_text = $req->carian_text;
            // dd($req);
            if(!empty($carian_type)){
                $query = \DB::table('tblfasiliti')
                            ->leftJoin('ddsa_kod_negeri', 'tblfasiliti.fas_negeri_id','=', 'ddsa_kod_negeri.neg_kod_negeri')
                            ->leftJoin('tblfasiliti_kategori', 'tblfasiliti.fas_kat_kod','=', 'tblfasiliti_kategori.faskat_kod')
                            ->select('tblfasiliti.*', 'ddsa_kod_negeri.neg_nama_negeri', 'tblfasiliti_kategori.faskat_desc')
                            ->orderBy('fas_name')
                            ->where(function($q) use ($carian_type, $carian_text){ 
                                if(!empty($carian_type)){
                                    if($carian_type=='Kod'){
                                        $q->where('fas_ptj_code', $carian_text);
                                    }
                                    else if($carian_type=='Nama'){
                                        $q->where('fas_name','like', "%{$carian_text}%");
                                    }
                                    else{
                                        $q->where('faskat_desc','like', "%{$carian_text}%");
                                    }
                                }
                            });
                $fasiliti = $query->get();
            }
            else{
                $fasiliti =  $query = \DB::table('tblfasiliti')
                                    ->leftJoin('ddsa_kod_negeri', 'tblfasiliti.fas_negeri_id','=', 'ddsa_kod_negeri.neg_kod_negeri')
                                    ->leftJoin('tblfasiliti_kategori', 'tblfasiliti.fas_kat_kod','=', 'tblfasiliti_kategori.faskat_kod')
                                    ->select('tblfasiliti.*', 'ddsa_kod_negeri.neg_nama_negeri', 'tblfasiliti_kategori.faskat_desc')
                                    ->orderBy('fas_name')->get();             
            }

            return response()->json([
                'fasiliti'=>$fasiliti,
            ]); 
        }
        else{
            
            $fas = fas::all();
            dd($fas);
            return response()->json([
                'fass'=>$fas,
            ]); 
        }       
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'fas_ptj_code'=> 'required',
            'fas_name'=> 'required',
            'fas_kat_kod'=> 'required',
            'fas_negeri_id'=> 'required',
        ],
        [
            'fas_ptj_code.required'=> 'Sila masukkan Kod Fasiliti',
            'fas_name.required'=> 'Sila masukkan Nama Fasiliti',
            'fas_kat_kod.required'=> 'Sila pilih Kategori',
            'fas_negeri_id.required'=> 'Sila pilih Negeri',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $fas = new Fasiliti;
            $fas->fas_ptj_code = $request->input('fas_ptj_code');
            $fas->fas_name = $request->input('fas_name');
            $fas->fas_kat_kod = $request->input('fas_kat_kod');
            $fas->fas_negeri_id = $request->input('fas_negeri_id');
            $fas->fas_created_by = \Auth::user()->id;
            $fas->fas_udated_by = \Auth::user()->id;
            $fas->fas_created_at = \Carbon\Carbon::now();
            $fas->fas_updated_at = \Carbon\Carbon::now();
            $fas->save();
            return response()->json([
                'status'=>200,
                'message'=>'Fasiliti berjaya ditambah'
            ]);
        }
    }

    public function edit($id)
    {
        $fasiliti = Fasiliti::find($id);
        if($fasiliti)
        {
            return response()->json([
                'status'=>200,
                'fasiliti'=> $fasiliti,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Maklumat Fasiliti tidak dijumpai.'
            ]);
        }
    }

    public function update(Request $request){
        $fasiliti_id = $request->fasiliti_id;
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'fas_ptj_code'=> 'required',
            'fas_name'=> 'required',
            'fas_kat_kod'=> 'required',
            'fas_negeri_id'=> 'required',
        ],
        [
            'fas_ptj_code.required'=> 'Sila masukkan Kod Fasiliti',
            'fas_name.required'=> 'Sila masukkan Nama Fasiliti',
            'fas_kat_kod.required'=> 'Sila pilih Kategori',
            'fas_negeri_id.required'=> 'Sila pilih Negeri',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else{
            $fas = Fasiliti::find($fasiliti_id);
            if($fas)
            {
                $fas->fas_ptj_code = $request->input('fas_ptj_code');
                $fas->fas_name = $request->input('fas_name');
                $fas->fas_kat_kod = $request->input('fas_kat_kod');
                $fas->fas_negeri_id = $request->input('fas_negeri_id');
                $fas->fas_udated_by = \Auth::user()->id;
                $fas->fas_updated_at = \Carbon\Carbon::now();
                $fas->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Maklumat Fasiliti berjaya dikemaskini'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'Maklumat Fasiliti Tidak Wujud.'
                ]);
            }

        }
    }

    public function destroy($id)
    {
        $fas = Fasiliti::find($id);
        if($fas)
        {
            $fas->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Maklumat Fasiliti Berjaya Dipadam.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Maklumat Fasiliti Tidak Wujud'
            ]);
        }
    }
}
