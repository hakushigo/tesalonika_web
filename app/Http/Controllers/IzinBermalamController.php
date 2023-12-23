<?php

namespace App\Http\Controllers;

use App\Models\IzinBermalam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\IzinBermalam as IzinBermalamResource;

class IzinBermalamController extends BaseController
{

    public function index(Request $request)
    {
        if($request->header('nim') != ''){
            $izinKeluar = IzinBermalam::where('mahasiswa', $request->header('nim'))->get();
            return response()->json(IzinBermalamResource::collection($izinKeluar));
        }else{
            $izinKeluar = IzinBermalam::all();
            return response()->json(IzinBermalamResource::collection($izinKeluar), 200);    
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'keperluan_ib' => 'required',
            'tempat_tujuan' => 'required',
            'mahasiswa' => 'required|exists:mahasiswa,nim',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Cek apakah izin hanya direquest pada waktu yang valid (Jumat diatas jam 17.00 dan Sabtu)
        $tanggalBerangkat = $request->input('tanggal_berangkat');
        $hari = date('l', strtotime($tanggalBerangkat));
        $jam = date('H', strtotime($tanggalBerangkat));

        if (!($hari === 'Friday' && $jam >= 17) && !($hari === 'Saturday' && ($jam >= 8 && $jam < 17))) {
            return response()->json(['error' => 'not_friday_saturday'], 400);
        }


        if (!($hari === 'Friday') && !($hari === 'Saturday')) {
            return response()->json(['error' => 'not_friday_saturday'], 400);
        }

        $izinBermalam = IzinBermalam::create($request->all());
        return response()->json(new IzinBermalamResource($izinBermalam), 201);
    }

    public function approve(Request $request)
    {
        $izinBermalam = IzinBermalam::find($request->get("id"));

        if (!$izinBermalam) {
            return response()->json(['error' => 'Izin Bermalam not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,declined',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $izinBermalam->status = $request->input('status');
        $izinBermalam->tanggal_approve = now();
        $izinBermalam->save();

        return response()->json(new IzinBermalamResource($izinBermalam), 200);
    }

    public function destroy(Request $request)
    {
        $izinBermalam = IzinBermalam::find($request->get('id'));

        if (!$izinBermalam) {
            return response()->json(['error' => 'Izin Bermalam not found'], 404);
        }

        $izinBermalam->status = "cancelled";
        $izinBermalam->save();
        return response()->json([], 204);
    }

    public function update(Request $request, $id)
    {
        $izinBermalam = IzinBermalam::find($id);

        if (!$izinBermalam) {
            return response()->json(['error' => 'Izin Bermalam not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'tanggal_berangkat' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'keperluan_ib' => 'required',
            'tempat_tujuan' => 'required',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $izinBermalam->update($request->all());

        return response()->json(new IzinBermalamResource($izinBermalam), 200);
    }
}
