<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Surveyor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class SurveyorController extends Controller
{
    public function index()
    {
        $Surveyor = Surveyor::orderBy(request('order_by'), request('sort'))
            ->filter(request(['q']))->paginate(request('per_page'));
        return response()->json($Surveyor, 200);
    }

    public function Surveyoruser(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|string|email',
            // 'password' => 'required|string|min:6'
        ]);

        try {
            $Surveyor = Surveyor::create([
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'status' => 1,
            ]);


            return response()->json([
                'status' => 'success',
                'message' => 'Surveyor Tersimpan',
                'Surveyor' => $Surveyor
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'ada kesalahan', 'error' => $e], 500);
        }
    }

    public function show($id)
    {
        $Surveyor = Surveyor::findOrFail($id);
        $Surveyor->load('user');
        $response = [
            'message' => 'Detail data',
            'data' => $Surveyor
        ];
        return response()->json($response);
    }

    public function update(Request $request, $id, $length = 8)
    {
        $dataSurveyor = Surveyor::findOrFail($id);
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randPass = '';
        for ($i = 0; $i < $length; $i++) {
            $randPass .= $characters[rand(0, $charactersLength - 1)];
        }
        $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|string|email',
        ]);
        try {
            $dataSurveyor->update([
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'status' => 2,
                'password' => $randPass,
            ]);
            if ($dataSurveyor) {
                $data = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($randPass),
                    'name' => $request->nama_lengkap,
                    'status' => 'aktif',
                    'role' => 'surveyor'
                ]);
                $dataSurveyor->update([
                    'user_id' => $data->id
                ]);
                $kirimEmail = ([
                    'name' => $data->name,
                    'email' =>  $data->email,
                    'password' => $randPass
                ]);
                KirimEmailController::index($kirimEmail);
            }

            $response = [
                'message' => 'data Surveyor berhasil di perbarui',
                'data' => $dataSurveyor
            ];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'ada kesalahan', 'error' => $e], 500);
        }
    }


    public function updateFull(Request $request, $id)
    {
        $data = Surveyor::findOrFail($id);
        $request->validate([
            'nik' => 'required|min:15|max:17',
            'no_asuransi_bpjs' => 'required|min:15|max:17',
            'nama_lengkap' => 'required|string',
            'email' => 'required|string|email',
            'no_hp1' => 'required',
            'no_hp2' => 'required',
            'no_rekening' => 'required',
        ]);

        try {
            if ($request->password_baru) {
                $data->update([
                    'nik' => $request->nik,
                    'nama_lengkap' => $request->nama_lengkap,
                    'email' => $request->email,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'gender' => $request->gender,
                    'agama' => $request->agama,
                    'no_hp1' => $request->no_hp1,
                    'no_hp2' => $request->no_hp2,
                    'nama_npwp' => $request->nama_npwp,
                    'nama_bank' => $request->nama_bank,
                    'no_rekening' => $request->no_rekening,
                    'nama_buku_tabungan' => $request->nama_buku_tabungan,
                    'no_asuransi_bpjs' => $request->no_asuransi_bpjs,
                    'nilai_toefl' => $request->nilai_toefl,
                    'bidang_survei' => $request->bidang_survei,
                    'status_kepegawaian' => $request->status_kepegawaian,
                    'profesi' => $request->profesi,
                    'alamat' => $request->alamat,
                    'provinsi' => $request->provinsi,
                    'kabkot' => $request->kabkot,
                    'kecamatan' => $request->kecamatan,
                    'kelurahan' => $request->kelurahan,
                    'kodepos' => $request->kodepos,
                    'domil_alamat' => $request->domil_alamat,
                    'domil_provinsi' => $request->domil_provinsi,
                    'domil_kabkot' => $request->domil_kabkot,
                    'domil_kecamatan' => $request->domil_kecamatan,
                    'domil_kelurahan' => $request->domil_kelurahan,
                    'domil_kodepos' => $request->domil_kodepos,
                    'password' => $request->password_baru,
                    'status' => 3
                ]);
                if ($data) {
                    JWTAuth::user()->update([
                        'password' => Hash::make($request->password_baru)
                    ]);
                }
                $response = [
                    'message' => 'Biodata berhasil di perbarui',
                    'data' => $data
                ];
                return response()->json($response, 201);
            } else {
                $data->update([
                    'nik' => $request->nik,
                    'nama_lengkap' => $request->nama_lengkap,
                    'email' => $request->email,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'gender' => $request->gender,
                    'agama' => $request->agama,
                    'no_hp1' => $request->no_hp1,
                    'no_hp2' => $request->no_hp2,
                    'nama_npwp' => $request->nama_npwp,
                    'nama_bank' => $request->nama_bank,
                    'no_rekening' => $request->no_rekening,
                    'nama_buku_tabungan' => $request->nama_buku_tabungan,
                    'no_asuransi_bpjs' => $request->no_asuransi_bpjs,
                    'nilai_toefl' => $request->nilai_toefl,
                    'bidang_survei' => $request->bidang_survei,
                    'status_kepegawaian' => $request->status_kepegawaian,
                    'profesi' => $request->profesi,
                    'alamat' => $request->alamat,
                    'provinsi' => $request->provinsi,
                    'kabkot' => $request->kabkot,
                    'kecamatan' => $request->kecamatan,
                    'kelurahan' => $request->kelurahan,
                    'kodepos' => $request->kodepos,
                    'domil_alamat' => $request->domil_alamat,
                    'domil_provinsi' => $request->domil_provinsi,
                    'domil_kabkot' => $request->domil_kabkot,
                    'domil_kecamatan' => $request->domil_kecamatan,
                    'domil_kelurahan' => $request->domil_kelurahan,
                    'domil_kodepos' => $request->domil_kodepos,
                ]);
                if ($data) {
                    JWTAuth::user()->update([
                        'email' => $request->email,
                        'name' => $request->nama_lengkap
                    ]);
                }
                $response = [
                    'message' => 'Profil berhasil di perbarui',
                    'data' => $data
                ];
                return response()->json($response, 201);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'ada kesalahan', 'error' => $e]);
        }
    }
}
