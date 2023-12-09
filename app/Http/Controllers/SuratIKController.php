<?php

namespace App\Http\Controllers;

use App\Models\SuratIK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\SuratIK as SuratIKResource;

class SuratIKController extends BaseController
{
    public function index()
    {
        $izinKeluar = SuratIK::all();
        return response()->json(SuratIKResource::collection($izinKeluar), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rencana_berangkat' => 'required|date',
            'rencana_kembali' => 'required|date',
            'keperluan_ik' => 'required',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $izinKeluar = SuratIK::create($request->all());

        // Jika tanggal pengambilan sudah lewat, ubah status menjadi 'declined'
        if ($izinKeluar->rencana_kembali <= now()) {
            $izinKeluar->status = 'declined';
            $izinKeluar->tanggal_approve = now();
            $izinKeluar->save();
        }

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
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $izinKeluar->update($request->all());

        // Jika tanggal pengambilan sudah lewat, ubah status menjadi 'declined'
        if ($izinKeluar->rencana_kembali <= now()) {
            $izinKeluar->status = 'declined';
            $izinKeluar->tanggal_approve = now();
            $izinKeluar->save();
        }

        return response()->json(new SuratIKResource($izinKeluar), 200);
    }

    public function approve(Request $request, $id)
    {
        $izinKeluar = SuratIK::find($id);

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

        // Jika tanggal approve diisi dan status belum diubah, ubah status berdasarkan tanggal_approve
        if ($izinKeluar->tanggal_approve && $izinKeluar->status === null) {
            $izinKeluar->status = ($izinKeluar->tanggal_approve <= now()) ? 'approved' : 'declined';
            $izinKeluar->save();
        }

        return response()->json(new SuratIKResource($izinKeluar), 200);
    }

    public function destroy($id)
    {
        $izinKeluar = SuratIK::find($id);

        if (!$izinKeluar) {
            return response()->json(['error' => 'Izin Keluar not found'], 404);
        }

        $izinKeluar->delete();
        return response()->json([], 204);
    }
}
