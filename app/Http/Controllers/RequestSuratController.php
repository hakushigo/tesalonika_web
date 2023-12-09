<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestSurat;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RequestSurat as RequestSuratController;


class SuratController extends BaseController
{
    public function index()
    {
        $surat = RequestSurat::all();
        return response()->json(RequestSuratController::collection($surat), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keperluansurat' => 'required',
            'deskripsi' => 'required',
            'tanggal_pengajuan' => 'required|date',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $surat = RequestSurat::create($request->all());
        return response()->json(new RequestSuratController($surat), 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'keperluansurat' => 'required',
            'deskripsi' => 'required',
            'tanggal_pengajuan' => 'required|date',
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $surat = RequestSurat::findOrFail($id);
        $surat->update($request->all());

        return response()->json(new RequestSuratController($surat), 200);
    }

    public function destroy($id)
    {
        $surat = RequestSurat::findOrFail($id);
        $surat->delete();

        return response()->json([], 204);
    }

    // Contoh metode untuk approve surat
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,declined',
            'tanggal_approve' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $surat = RequestSurat::findOrFail($id);
        $surat->update([
            'status' => $request->status,
            'tanggal_approve' => $request->tanggal_approve,
        ]);

        return response()->json(new RequestSuratController($surat), 200);
    }
}
