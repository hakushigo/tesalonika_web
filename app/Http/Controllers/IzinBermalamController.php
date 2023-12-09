<?

namespace App\Http\Controllers;

use App\Models\IzinBermalam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\IzinBermalam as IzinBermalamResource;

class IzinBermalamController extends BaseController
{

    public function index()
    {
        $izinBermalams = IzinBermalam::all();
        return response()->json(IzinBermalamResource::collection($izinBermalams), 200);
    }

    public function store(Request $request)
    {
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

        // Cek apakah izin hanya direquest pada waktu yang valid (Jumat diatas jam 17.00 dan Sabtu)
        $tanggalBerangkat = $request->input('tanggal_berangkat');
        $hari = date('l', strtotime($tanggalBerangkat));
        $jam = date('H', strtotime($tanggalBerangkat));

        if (!($hari === 'Friday' && $jam >= 17) && !($hari === 'Saturday' && ($jam >= 8 && $jam < 17))) {
            return response()->json(['error' => 'Izin hanya bisa direquest pada Jumat di atas jam 17.00 dan Sabtu'], 400);
        }

        $izinBermalam = IzinBermalam::create($request->all());

        return response()->json(new IzinBermalamResource($izinBermalam), 201);
    }

    public function approve(Request $request, $id)
    {
        $izinBermalam = IzinBermalam::find($id);

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

    public function destroy($id)
    {
        $izinBermalam = IzinBermalam::find($id);

        if (!$izinBermalam) {
            return response()->json(['error' => 'Izin Bermalam not found'], 404);
        }

        $izinBermalam->delete();
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
