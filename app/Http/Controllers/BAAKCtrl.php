<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BAAK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class BAAKCtrl extends Controller
{

    function getInfo(Request $request){
        $BAAK = BAAK::where("login_token","=",$request->header('login_token'));
        if(($BAAK->exists())){
            $BAAKRes = $BAAK->get()[0];
            return Response::json([
                "username"=> $BAAKRes->username,
            ]);
        }else{
            return Response::json([
                "username" => "",
            ], 500);
        }
    }

    function login(Request $request){
        $v = Validator::make($request->all(), [
            "nim" => "required",
            "password" => "required"
        ]);

        // find the user 
        $qwhere = BAAK::where("username", "=", $request->input("username"));
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
                "error" => "baak_not_found"
            ], 400);
        }
    }
}