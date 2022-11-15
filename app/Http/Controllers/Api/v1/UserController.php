<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy(request('order_by'), request('sort'))
            ->filter(request(['q']))->paginate(request('per_page'));
        return response()->json($user, 200);
    }

    public function store(Request $request)
    {
        // $request->validate(([
        //     'name' => 'required|string',
        //     'email' => 'required|string|email'
        // ]));
        try {
            DB::beginTransaction();
            if (!$request->has('id')) {
                $validatedData = Validator::make($request->all(), [
                    'name' => 'required',
                ]);
                if ($validatedData->fails()) {
                    return response()->json($validatedData->errors(), 422);
                }
                $user = User::firstOrCreate([
                    'name' => $request->name,
                    'email' => $request->email,
                    'status' => $request->status,
                    'role' => $request->role,
                    'password' => Hash::make($request->password)
                ]);
            } else {
                $user = User::find($request->id);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'status' => $request->status,
                    'role' => $request->role,
                    'password' => Hash::make($request->password)
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                // 'message' => 'Data berhasil di tambah',
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ada kealahan', 'error' => $e], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        // if ($request->hasFile('gambar')) {
        //     $request->validate([
        //         'gambar' => 'required|image|mimes:jpeg,png,jpg'
        //     ]);
        //     $path = $request->file('gambar')->store('images', 'public');

        //     if (!$path) {
        //         return response()->json(['message' => 'Gambar Gagal Disimpan'], 500);
        //     }
        //     $user = User::find($request->id);
        //     $user->photo = $path;
        //     if (!$user->save()) {
        //         return response()->json(['message' => 'Database Gagal Disimpan'], 500);
        //     }
        // return response()->json(['message' => 'Gambar Berhasil Disimpan'], 200);
        // }
        // return new JsonResponse(['message' => 'tidak ada file'], 500);


        $user = User::find($request->id);
        if ($request->hasFile('gambar') && $user->photo !== null) {
            // return response()->json(['message' => 'user masuk update'], 200);
            $old_path = $user->photo;
            Storage::delete('public/' . $old_path);
            $request->validate([
                'gambar' => 'required|image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('gambar')->store('images', 'public');

            $save = User::find($request->id)->update([
                'photo' => $path,
            ]);

            if ($save) {
                return response()->json(['message' => 'Gambar Berhasil Disimpan'], 200);
            } else {
                return response()->json([
                    'message'       => 'Error on upload',
                ], 500);
            }
        } else if ($request->hasFile('gambar')) {
            // return response()->json(['message' => 'user mau buat'], 200);
            $path = $request->file('gambar')->store('images', 'public');
            if (!$path) {
                return new JsonResponse(['message' => 'Gambar Gagal Disimpan'], 500);
            }
            $user = User::find($request->id);
            $user->photo = $path;
            if (!$user->save()) {
                return new JsonResponse(['message' => 'Database Gagal Disimpan'], 500);
            }
            return new JsonResponse(['message' => 'Gambar Berhasil Disimpan'], 200);
        } else {
            // return response()->json(['message' => 'keluar aja'], 200);
            exit;
        }

        return response()->json([
            'message' => 'Error on Updated',
        ], 500);
    }
}
