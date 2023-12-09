<?php

namespace App\Http\Controllers;

use App\Models\RequestRuangan;
use Illuminate\Http\Request as HttpRequest;
use App\Http\Resources\RequestRuangan as RequestRuanganResource;

class RequestRuanganController extends BaseController
{
    public function store(HttpRequest $request)
    {
        $validatedData = $request->validate([
            'mahasiswa_id' => 'required',
            'ruangan_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $requestedDate = now()->toDateString(); // Tanggal request saat ini

        // Cek apakah ruangan sudah dipesan pada tanggal ini
        $existingRequest = RequestRuangan::where('ruangan_id', $validatedData['ruangan_id'])
            ->whereDate('start_time', $requestedDate)
            ->first();

        if ($existingRequest) {
            return response()->json(['message' => 'Ruangan sudah dipesan pada waktu ini'], 400);
        }

        $newRequest = RequestRuangan::create([
            'mahasiswa_id' => $validatedData['mahasiswa_id'],
            'ruangan_id' => $validatedData['ruangan_id'],
            'status' => null,
            'tanggal_terima' => null,
            'start_time' => $validatedData['start_time'],
            'end_time' => $validatedData['end_time'],
            'keterangan' => $request->input('keterangan'), // Tambahan keterangan
        ]);

        return response()->json(new RequestRuanganResource($newRequest), 201);
    }

    public function index()
    {
        $requests = RequestRuangan::all();
        return response()->json(RequestRuanganResource::collection($requests), 200);
    }

    public function update(HttpRequest $request, $id)
    {
        $updatedRequest = RequestRuangan::findOrFail($id);

        if ($updatedRequest->tanggal_terima) {
            return response()->json(['message' => 'Request already approved, cannot be updated'], 400);
        }

        $validatedData = $request->validate([
            'mahasiswa_id' => 'required',
            'ruangan_id' => 'required',
            'status' => 'required|in:approved,declined',
            'start_time' => 'required',
            'end_time' => 'required',
            'keterangan' => 'nullable', // Keterangan bisa kosong
        ]);

        $updatedRequest->mahasiswa_id = $validatedData['mahasiswa_id'];
        $updatedRequest->ruangan_id = $validatedData['ruangan_id'];
        $updatedRequest->status = $validatedData['status'];
        $updatedRequest->start_time = $validatedData['start_time'];
        $updatedRequest->end_time = $validatedData['end_time'];
        $updatedRequest->keterangan = $validatedData['keterangan'];

        $updatedRequest->save();

        return response()->json(new RequestRuanganResource($updatedRequest), 200);
    }

    //Admin Approve 
    
    public function approve(HttpRequest $request, $id)
    {
        $approvedRequest = RequestRuangan::findOrFail($id);

        if ($approvedRequest->tanggal_terima) {
            return response()->json(['message' => 'Request already approved'], 400);
        }

        $validatedData = $request->validate([
            'status' => 'required|in:approved,declined',
        ]);

        $approvedRequest->status = $validatedData['status'];
        $approvedRequest->tanggal_terima = now();

        $approvedRequest->save();

        return response()->json(['message' => 'Request approved successfully']);
    }
}
