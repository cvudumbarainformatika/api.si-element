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

class SurveyorController extends Controller
{
    public function index()
    {
        $item = Surveyor::paginate(10);
        $data = SurveyorResource::collection($item);

        return $data;

    }

    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            // $new_pass = $request->password;
            // $password = '';
            // // DATA BARU
            if (!$request->has('id')) {
            //     empty($request->input('password')) ?
            //         $password = $request->nip : $password = $new_pass;

                $request->validate([
                    'nik' => 'unique:surveyors',
                    'email' => 'unique:users',
                    'nama' => 'required',
                ]);

                $user = User::create([
                    'email' => $request->nik,
                    'name' => $request->nama,
                    'password' => Hash::make($request->nik)
                ]);
                $user->surveyor()->create($request->only([
                    'nik','no_hp','nama','alamat','provinsi','kabkot','kecamatan','kelurahan','kodepos','tempat_lahir','tanggal_lahir','gender','agama'
                ]));


                // $auth->log("Memasukkan data PEGAWAI {$user->name}");

                // UPDATE DATA LAMA
            } else {
                $user = User::find($request->user_id);

                // $data = User::find($request->user_id);
                // $user->update([
                //     'email' => $request->email,
                //     'name' => $request->nama,
                // ]);
                // jika ada isian password diubah
                // if (!empty($request->input('password'))) {
                //     $user->update(['password' => Hash::make($request->password)]);
                // }
                // update data pegawai
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
            /* Transaction successful. */
            return response()->json(['message' => 'Success', 'result' => $request->all()], 201);
        } catch (\Exception $e) {

            DB::rollback();
            /* Transaction failed. */
            return response()->json(['message' => 'Ada Kesalahan'], 500);
        }
    }
}
