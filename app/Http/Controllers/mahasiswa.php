<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\mahasiswa as MahasiswaModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class Mahasiswa extends Controller
{
    function signup(Request $request){

        $v = Validator::make($request->all(), [
            "nim"=> "required",
            "nama"=> "required",
            "password"=> "required"
        ]);

        if($v->fails()){
            return Response::json([
                "error" => "ERR::SIGNUP::FAILED_VALIDATED",
            ], 500);
        };
        $data = [
            "nim" => $request->input("nim"),
            "nama" => $request->input("nama"),
            "password" => bcrypt($request->input("password")),
        ];

        MahasiswaModels::create($data);
    }

    function login(Request $request){
        $v = Validator::make($request->all(), [
            "nim" => "required",
            "password" => "required"
        ]);

        // find the user 
        $nim = MahasiswaModels::where("nim", "=", $request->input("nim"))->get()[0];
        if($nim == "null" || $nim->password != bcrypt($request->input("password"))){
            return Response::json([
                "error" => "ERR::AUTH::WRONG_CREDENTIALS"
            ], 500);
        }
    }

    function destroy(Request $request){

    }
}
