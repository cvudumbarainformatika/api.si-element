<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $register = Register::all();
        return response()->json($register, 200);
    }

    public function registeruser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|string|email',
            // 'password' => 'required|string|min:6'
        ]);

        try {
            $register = Register::create([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'email' => $request->email,
                'status' => 1,
            ]);


            return response()->json([
                'status' => 'success',
                'message' => 'Register Tersimpan',
                'register' => $register
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'ada kesalahan', 'error' => $e], 500);
        }
    }

    public function show(Register $register, $id)
    {
        $register = Register::findOrFail($id);
        $register->load('user');
        $response = [
            'message' => 'Detail data',
            'data' => $register
        ];
        return response()->json($response);
    }

    public function update(Request $request, $id, $length = 8)
    {
        $dataRegister = Register::findOrFail($id);
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randPass = '';
        for ($i = 0; $i < $length; $i++) {
            $randPass .= $characters[rand(0, $charactersLength - 1)];
        }
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|string|email',
        ]);
        try {
            $dataRegister->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'email' => $request->email,
                'status' => 2,
                'password' => $randPass,
            ]);
            if ($dataRegister) {
                $data = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($randPass),
                    'name' => $request->nama,
                    'status' => 'aktif',
                    'role' => 'surveor'
                ]);
                $dataRegister->update([
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
                'message' => 'data register berhasil di perbarui',
                'data' => $dataRegister
            ];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'ada kesalahan', 'error' => $e], 500);
        }
    }


    public function updateFull(Request $request, $id)
    {
        $data = Register::findOrFail($id);
        $user = auth()->user();
        $request->validate([
            'nik' => 'required',
            'nama' => 'required|string',
            'email' => 'required|string|email',
            'nohp1' => 'required',
            'nohp2' => 'required',
            'norekening' => 'required',
            'password_baru' => 'required|min:6|confirmed',
            'password_baru_confirmation' => 'required|min:6'
        ]);

        try {
            $data->update([
                'nik' => $request->nik,
                'nama' => $request->nama,
                'email' => $request->email,
                'nohp1' => $request->nohp1,
                'nohp2' => $request->nohp2,
                'norekening' => $request->norekening,
                'password' => $request->password_baru,
                'status' => 3
            ]);
            if ($data) {
                $data->user()->update([
                    'password' => Hash::make($request->password_baru)
                ]);
            }
            $response = [
                'message' => 'Biodata berhasil di tambah',
                'data' => $data
            ];
            return response()->json($response, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'ada kesalahan', 'error' => $e]);
        }
    }
}
