<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Provesi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvesiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provesi = Provesi::orderBy(request('order_by'), request('sort'))
            ->filter(request(['q']))->paginate(request('per_page'));
        return response()->json($provesi, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if (!$request->has('id')) {
                $validateData = Validator::make($request->all(), [
                    'nama' => 'required'
                ]);
                if ($validateData->fails()) {
                    return response()->json($validateData->errors(), 422);
                }
                Provesi::firstOrCreate([
                    'nama' => $request->nama
                ]);
            } else {
                $provesi = Provesi::find($request->id);
                $provesi->update([
                    'nama' => $request->nama
                ]);
            }
            return response()->json([
                'status' => 'success'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'ada kesalahan',
                'error' => $e
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = Provesi::find($request->id);
        try {
            $data->delete();
            return response()->json([
                'message' => 'Data terhapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ada kesalahan',
                'error' => $e
            ], 500);
        }
    }
}
