<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\BidangSurvei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        try {
            DB::beginTransaction();
            if (!$request->has('id')) {
                $validateData = Validator::make($request->all(), [
                    'nama' => 'required'
                ]);
                if ($validateData->fails()) {
                    return response()->json($validateData->errors(), 422);
                }
                BidangSurvei::firstOrCreate([
                    'nama' => $request->nama
                ]);
            } else {
                $bidangSurvei = BidangSurvei::find($request->id);
                $bidangSurvei->update([
                    'nama' => $request->nama
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
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
