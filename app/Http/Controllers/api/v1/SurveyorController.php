<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SurveyorResource;
use App\Models\Surveyor;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SurveyorController extends Controller
{
    public function index()
    {
        $item = Surveyor::with(['user'])
        ->orderBy(request('order_by'), request('sort'))
        ->filter(request(['q']))
        ->paginate(request('per_page'));
        $data = SurveyorResource::collection($item);

        return $data;

    }

    public function store(Request $request)
    {

        try {

            DB::beginTransaction();

            if (!$request->has('id')) {

                $validator = Validator::make($request->all(), [
                    'nik' => 'unique:surveyors',
                    'nama' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }
                $user = User::create([
                    'email' => $request->nik.'@app.com',
                    'name' => $request->nama,
                    'password' => bcrypt($request->nik)
                ]);
                $user->surveyor()->create($request->only([
                    'nik','no_hp','nama','alamat','provinsi','kabkot','kecamatan','kelurahan','kodepos','tempat_lahir','tanggal_lahir','gender','agama'
                ]));


                // $auth->log("Memasukkan data PEGAWAI {$user->name}");
            } else {
                $user = User::find($request->user_id);
                $user->surveyor()->update([
                    // 'nik' => $request->nik,
                    'no_hp' => $request->no_hp,
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'provinsi' => $request->provinsi,
                    'kabkot' => $request->kabkot,
                    'kecamatan' => $request->kecamatan,
                    'kelurahan' => $request->kelurahan,
                    'kodepos' => $request->kodepos,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'gender' => $request->gender,
                    'agama' => $request->agama,
                ]);

                // $auth->log("Merubah data PEGAWAI {$user->name}");
            }

            DB::commit();
            return new JsonResponse(['message' => 'Success', 'result' => $request->all()], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return new JsonResponse(['message' => $e],500);
        }
    }

    public function destroy(Request $request)
    {
        $auth = $request->user();
        $auth_id = $auth->id;
        $data = Surveyor::find($request->id);
        if ($auth_id === $data->user_id) {
            return response()->json([
                'message' => 'Tidak bisa hapus diri sendiri'
            ], 500);
        }

        $del = $data->user()->delete();
        if (!$del) {
            return response()->json([
                'message' => 'Hapus Data Error!'
            ], 500);
        }

        return response()->json([
            'message' => 'Data sukses terhapus'
        ], 200);
    }
}
