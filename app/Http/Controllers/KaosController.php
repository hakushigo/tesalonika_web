<?php

namespace App\Http\Controllers;

use App\Models\Kaos;
use Illuminate\Http\Request;
use App\Http\Resources\Kaos as KaosResource;
use Illuminate\Support\Facades\Validator;

class KaosController extends Controller
{
    public function index()
    {
        $kaos = Kaos::all();
        return response()->json(KaosResource::collection($kaos), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ukuran' => 'required',
            'kode_ukuran' => 'required|unique:kaos',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $kaos = Kaos::create($validator->validated());
        return response()->json(new KaosResource($kaos), 201);
    }

    public function show($id)
    {
        $kaos = Kaos::findOrFail($id);
        return response()->json(new KaosResource($kaos), 200);
    }

    public function update(Request $request, $id)
    {
        $kaos = Kaos::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ukuran' => 'required',
            'kode_ukuran' => 'required|unique:kaos,kode_ukuran,' . $kaos->id,
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $kaos->update($validator->validated());
        return response()->json(new KaosResource($kaos), 200);
    }

    public function destroy($id)
    {
        $kaos = Kaos::findOrFail($id);
        $kaos->delete();
        return response()->json([], 204);
    }
}

?>
