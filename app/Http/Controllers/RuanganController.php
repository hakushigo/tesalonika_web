<?php

namespace App\Http\Controllers;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Ruangan as RuanganResource;

class RuanganController extends BaseController
{
    public function index(Request $request){
        $ruangan = Ruangan::all();
        return response()->json(RuanganResource::collection($ruangan),200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nama' =>'required',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validator Error.', $validator->errors());
        }
        
        $ruangan = Ruangan::create($input);
        return $this->sendResponse(new RuanganController($ruangan), 'ruangan created succesfully.');
    }

    public function delete($id)
    {
        $ruangan = Ruangan::find($id);

        if (is_null($ruangan)) {
            return $this->sendError('Ruangan not found.');
        }

        $ruangan->delete();

        return $this->sendResponse([], 'Ruangan deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $ruangan = Ruangan::find($id);

        if (is_null($ruangan)) {
            return $this->sendError('ruangan not found.');
        }

        $ruangan->nama = $input['nama'];
        $ruangan->save();

        return $this->sendResponse(new RuanganResource($ruangan), 'ruangan updated successfully.');
    }


}
