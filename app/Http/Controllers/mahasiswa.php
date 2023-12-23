<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\mahasiswa as MahasiswaModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Mahasiswa extends Controller
{
    function getInfo(Request $request){
        $mahasiswa = MahasiswaModels::where("login_token","=",$request->header('login_token'));
        if(($mahasiswa->exists())){
            $mahasiswaRes = $mahasiswa->get()[0];
            return Response::json([
                "nim"=> $mahasiswaRes->nim,
                "nama"=> $mahasiswaRes->nama,
                "nomorHP"=> $mahasiswaRes->nomorHP,
                "nomorKTP" => $mahasiswaRes->nomorKTP
            ]);
        }else{
            return Response::json([
                "nim"=> 0,
                "nama"=> 0,
                "nomorHP"=> 0,
                "nomorKTP" => 0
            ], 500);
        }
    }
    function signup(Request $request){

        $v = Validator::make($request->all(), [
            "nim"=> "required",
            "nama"=> "required",
            "password"=> "required",
            "nomorHP"=> "required",
            "nomorKTP" => "required"
        ]);

        if($v->fails()){
            return Response::json([
                "error" => "ERR::SIGNUP::FAILED_VALIDATED",
            ], 500);
        };

        $data = [
            "nim" => $request->input("nim"),
            "nama" => $request->input("nama"),
            "password" => Hash::make($request->input("password")),
            "nomorHP" => $request->input("nomorHP"),
            "nomorKTP" => $request->input("nomorKTP"),
            "login_token" => Hash::make(Str::random(40))
        ];

        MahasiswaModels::create($data);

        return Response::json([
            "login_token" => $data["login_token"]
        ]);
    }

    function login(Request $request){
        $v = Validator::make($request->all(), [
            "nim" => "required",
            "password" => "required"
        ]);

        // find the user 
        $qwhere = MahasiswaModels::where("nim", "=", $request->input("nim"));
        if($qwhere->exists()){
            $usr = $qwhere->get()[0];

            if($usr == "null" || !Hash::check($request->input("password"), $usr->password)){
                return Response::json([
                    "error" => "ERR::AUTH::WRONG_CREDENTIALS",
                    "usr" => $usr->password,
                    "usrpass" => bcrypt($request->input("password"))
                ], 500);
            }else{
                $data = [
                    "login_token" => Hash::make(Str::random(40))
                ];
                $qwhere->update($data);
        
                return Response::json([
                    "login_token" => $data["login_token"]
                ]);    
            }
        }else{
            return Response::json([
                "error" => "mahasiswa_not_found"
            ], 400);
        }

    }

    function fetchHomepageData(Request $request){
        $v = Validator::make($request->all(), [
            "login_token" => "required"
        ]);

        $data = MahasiswaModels::where("login_token", "=", $request->get("login_token"))->get()[0];
        if($data->count() > 0){
            return Response::json([
                "nim"=> $data->nim,
                "nama"=> $data->nama,
                "password"=> $data->password,
                "nomorHP"=> $data->nomorHP,
                "nomorKTP" => $data->nomorKTP
            ]);    
        }else{
            return Response::json([
                "error" => "ERR::AUTH::WRONG_CREDENTIALS"
            ], 500);   
        }
    }

    function destroy(Request $request){

    }
}
