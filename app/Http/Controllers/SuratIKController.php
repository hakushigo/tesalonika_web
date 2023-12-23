<?php

namespace App\Http\Controllers;

use App\Models\SuratIK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SuratIK as SuratIKResource;

class SuratIKController extends BaseController
{
    public function index(Request $request)
    {
        if($request->header('nim') != ''){
            $izinKeluar = SuratIK::where('mahasiswa', $request->header('nim'))->get();
            return response()->json(SuratIKResource::collection($izinKeluar));
        }else{
            $izinKeluar = SuratIK::all();
            return response()->json(SuratIKResource::collection($izinKeluar), 200);    
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rencana_berangkat' => 'required|date',
            'rencana_kembali' => 'required|date',
            'keperluan_ik' => 'required',
            'mahasiswa' => 'required|exists:mahasiswa,nim',
            'status' => 'waiting'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $izinKeluar = SuratIK::create($request->all());
        return response()->json(new SuratIKResource($izinKeluar), 201);
    }

    public function update(Request $request, $id)
    {
        $izinKeluar = SuratIK::find($id);

        if (!$izinKeluar) {
            return response()->json(['error' => 'Izin Keluar not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'rencana_berangkat' => 'required|date',
            'rencana_kembali' => 'required|date',
            'keperluan_ik' => 'required',
            'mahasiswa_id' => 'required|exists:mahasiswa,nim',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $izinKeluar->update($request->all());
        return response()->json(new SuratIKResource($izinKeluar), 200);
    }

    public function approve(Request $request)
    {
        $izinKeluar = SuratIK::find($request->get("id"));

        if (!$izinKeluar) {
            return response()->json(['error' => 'Izin Keluar not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,declined',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $izinKeluar->status = $request->input('status');
        $izinKeluar->tanggal_approve = now();
        $izinKeluar->save();

        return response()->json(new SuratIKResource($izinKeluar), 200);
    }

    public function destroy(Request $request)
    {
        if($request->has("id")){
            $izinKeluar = SuratIK::find($request->id);

            $izinKeluar->status = "cancelled";
            $izinKeluar->save();
            
            return response()->json([], 200);    
        }else{
            return response()->json([
                "error" => "ID?"
            ], 500);
        }
    }
}
