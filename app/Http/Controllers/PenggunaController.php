<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;

class PenggunaController extends Controller
{
    public function index(){
        return view('pentadbir.pengguna.index');
    }

    public function ajaxAll(Request $req){
        if($req->isMethod('post')) {
            $carian_type = $req->carian_type;
            $carian_text = $req->carian_text;
            // dd($req);
            if(!empty($carian_type)){
                $query = User::where(function($q) use ($carian_type, $carian_text){
                    if(!empty($carian_type)){
                        if($carian_type=='Emel'){
                            $q->where('email','like', "%{$carian_text}%");
                        }
                        else{
                            $q->where('name','like', "%{$carian_text}%");
                        }
                    }
                });
                $user = $query->get();
            }
            else{
                $user = User::all();                
            }

            return response()->json([
                'users'=>$user,
            ]); 
        }
        else{
            
            $user = User::all();
            dd($user);
            return response()->json([
                'users'=>$user,
            ]); 
        }       
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'role'=> 'required',
        ],
        [
            'name.required'=> 'Sila masukkan Nama',
            'email.required'=> 'Sila masukkan Email',
            'password.required'=> 'Sila masukkan Katalaluan',
            'role.required'=> 'Sila pilih Peranan Pengguna',
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
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->role = $request->input('role');
            $user->created_at = Carbon::now();
            $user->updated_at = Carbon::now();
            $user->save();
            return response()->json([
                'status'=>200,
                'message'=>'Pengguna berjaya ditambah'
            ]);
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        if($user)
        {
            return response()->json([
                'status'=>200,
                'user'=> $user,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Maklumat pengguna tidak dijumpai.'
            ]);
        }
    }

    public function update(Request $request){
        $user_id = $request->user_id;
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required',
            'role'=> 'required',
        ],
        [
            'name.required'=> 'Sila masukkan Nama',
            'email.required'=> 'Sila masukkan Email',
            'role.required'=> 'Sila pilih peranan',
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
            $user = User::find($user_id);
            if($user)
            {
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->role = $request->input('role');
                $user->status = $request->input('status');
                $user->updated_at = Carbon::now();
                $user->update();
                return response()->json([
                    'status'=>200,
                    'message'=>'Maklumat Pengguna berjaya dikemaskini'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'Maklumat Pengguna Tidak Wujud.'
                ]);
            }

        }
    }

    public function setPass($id)
    {
        $user = User::find($id);
        if($user)
        {            
            $user->password = Hash::make(123456);
            $user->updated_at = Carbon::now();
            $user->update();
            return response()->json([
                'status'=>200,
                'message'=>'Katalaluan telah diset kepada 123456'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Maklumat Pengguna Tidak Wujud.'
            ]);
        }

    }
}
