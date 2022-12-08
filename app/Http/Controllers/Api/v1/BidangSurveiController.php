<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BidangSurvei;
use Illuminate\Http\Request;

class BidangSurveiController extends Controller
{
    public function index()
    {
        $bidang = BidangSurvei::orderBY(request('order_by'), request('sort'))
            ->filter(request(['q']))->paginate(request('per_page'));
        return response()->json($bidang, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        try {
            BidangSurvei::create([
                'nama' => $request->nama
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Bidang survei tersimpan'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'ada kesalahan', 'error' => $e], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = BidangSurvei::find($request->id);
            $data->update([
                'nama' => $request->nama
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Bidang survei di perbarui'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'ada kesalahan', 'error' => $e], 500);
        }
    }

    public function destroy(Request $request)
    {
        $data = BidangSurvei::find($request->id);
        try {
            $data->delete();
            return response()->json(['message' => 'Data terhapus'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ada kesalahan',
                'error' => $e
            ]);
        }
    }
}
