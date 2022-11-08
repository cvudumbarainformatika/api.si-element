<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function destroy(Request $request)
    {
        $id = $request->id;

        $data = User::find($id);
        $del = $data->delete();

        if (!$del) {
            return response()->json(['message' => 'Error on delete'], 500);
        }

        return response()->json([
            'message' => 'Data terhapus'
        ], 200);
    }
}
