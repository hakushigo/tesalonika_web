<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\api_access;

class CheckAPIKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->get("api_key") != null){
            $retrieve_data = api_access::where("api_key", '=', $request->get("api_key"))->get()[0];
            if($retrieve_data == null){
                return Response::json([
                    "error" => "Your API key doesn't exsists",
                ]);
            }

            $maxvalidtmpstmp = strtotime($retrieve_data->valid_until);
            if(time() < $maxvalidtmpstmp){
                return $next($request);
            }else{
                return Response::json([
                    "error" => "Your API key is expired, please get a new one"
                ], 500);    
            }
        }else{
            return Response::json([
                "error"=> "You don't provide the API key in the request body"
            ], 500);
        }
    }
}
