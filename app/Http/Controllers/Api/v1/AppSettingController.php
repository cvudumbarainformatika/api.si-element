<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppSettingController extends Controller
{
    //
    public function getSetting()
    {
        $data = AppSetting::find(1);
        return new JsonResponse($data, 200);
    }

    public function storeSetting(Request $request)
    {
        // return new JsonResponse((array) $request->all());
        $data = null;
        $first = $request->nama;
        $second = $request->all();
        unset($second['nama']);
        try {
            DB::beginTransaction();
            $valid = Validator::make($request->all(), [
                'nama' => 'required'
            ]);
            // $valid = $request->validate([
            //     'nama' => 'required'
            // ]);
            if ($valid->fails()) {
                return new JsonResponse($valid->errors(), 422);
            }
            $data = AppSetting::updateOrCreate(['nama' => $first], $second);

            DB::commit();
            return new JsonResponse(['message' => 'sukses'], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return new JsonResponse([
                'message' => 'error',
                'error' => $e,
                'first' => $first,
                'second' => $second,
                'data' => $data,
            ], 500);
        }
    }
}
