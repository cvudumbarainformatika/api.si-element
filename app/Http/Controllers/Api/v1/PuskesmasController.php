<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PuskesmasController extends Controller
{
    public function index()
    {
        $puskesmas = Puskesmas::orderBy(request('order_by'), request('sort'))
            ->filter(request(['q']))->paginate(request('per_page'));
        return response()->json($puskesmas, 200);
    }

    public function puskesmasUser(Request $request)
    {
        $request->validate([
            'nomor' => 'required',
            'nama' => 'required',
            'email' => 'required|email'
        ]);

        try {
            Puskesmas::create([
                'nomor' => $request->nomor,
                'nama' => $request->nama,
                'email' => $request->email,
                'status' => 1
            ]);

            return response()->json(['status' => 'success', 'message' => 'Data puskesmas tersimpan'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'ada kesalahan', 'error' => $e], 500);
        }
    }
}
