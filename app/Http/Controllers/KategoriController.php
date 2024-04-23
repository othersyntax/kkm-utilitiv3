<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(){
        return view('pentadbir.kategori.index');
    }

    public function ajaxAll(Request $req){
        if($req->isMethod('post')) {
            $carian_type = $req->carian_type;
            $carian_text = $req->carian_text;
            // dd($req);
            if(!empty($carian_type)){
                $query = Kategori::where(function($q) use ($carian_type, $carian_text){
                    if(!empty($carian_type)){
                        if($carian_type=='Kod'){
                            $q->where('faskat_kod',$carian_text);
                        }
                        else{
                            $q->where('faskat_desc','like', "%{$carian_text}%");
                        }
                    }
                });
                $cat = $query->get();
            }
            else{
                $cat = Kategori::all();                
            }

            return response()->json([
                'cats'=>$cat,
            ]); 
        }
        else{
            
            $cat = Kategori::all();
            // dd($cat);
            return response()->json([
                'cats'=>$cat,
            ]); 
        }            
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'faskat_kod'=> 'required',
            'faskat_desc'=> 'required',
        ],
        [
            'faskat_kod.required'=> 'Sila masukkan Kod Kategori',
            'faskat_desc.required'=> 'Sila masukkan Kategori',
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
            $cat = new Kategori;
            $cat->faskat_kod = $request->input('faskat_kod');
            $cat->faskat_desc = $request->input('faskat_desc');
            $cat->faskat_created = \Carbon\Carbon::now();
            $cat->save();
            return response()->json([
                'status'=>200,
                'message'=>'Kategori berjaya ditambah'
            ]);
        }
    }

    public function edit($id)
    {
        $cat = Kategori::find($id);
        if($cat){
            return response()->json([
                'status'=>200,
                'cats'=> $cat,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Maklumat Kategori tidak dijumpai.'
            ]);
        }
    }

    public function update(Request $request){
        $faskat_id = $request->faskat_id;
        $validator = Validator::make($request->all(), [
            'faskat_kod'=> 'required',
            'faskat_desc'=> 'required',
            'faskat_status'=> 'required',
        ],
        [
            'faskat_kod.required'=> 'Sila masukkan Kod Kategori',
            'faskat_desc.required'=> 'Sila masukkan Kategori',
            'faskat_status.required'=> 'Sila pilih Kategori',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }
        else{
            $fas = Kategori::find($faskat_id);
            if($fas)
            {
                $fas->faskat_kod = $request->input('faskat_kod');
                $fas->faskat_desc = $request->input('faskat_desc');
                $fas->faskat_status = $request->input('faskat_status');
                $fas->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Maklumat Kategori berjaya dikemaskini'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'Maklumat Kategori Tidak Wujud.'
                ]);
            }

        }
    }

    public function destroy($id)
    {
        $fas = Kategori::find($id);
        if($fas)
        {
            $fas->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Maklumat Kategori Berjaya Dipadam.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Maklumat Kategori Tidak Wujud'
            ]);
        }
    }
}
