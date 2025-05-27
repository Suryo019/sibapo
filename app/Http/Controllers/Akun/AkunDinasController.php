<?php

namespace App\Http\Controllers\Akun;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AkunDinasController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'role_id' => 'required|exists:roles,id',
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            $validated['password'] = bcrypt($validated['password']);
    
            $data = User::create($validated);
            $user = User::with('role')->find($data->id);

            return response()->json([
                'message' => 'Akun berhasil disimpan',
                'data' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data akun',
                'error' => $th->getMessage()
            ], 500);
        }
    }    

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request->email);
            $user = User::findOrFail($id);
    
            $rules = [
                'role_id' => 'required|exists:roles,id',
                'name' => 'required|string|max:255',
            ];
            
            if ($request->email != $user->email) {
                $rules['email'] = 'required|string|email|max:255|unique:users,email,' . $user->id;
            }

            if ($request->username != $user->username) {
                $rules['username'] = 'required|string|max:255|unique:users,username,' . $user->id;
            }

            $validated = $request->validate($rules);
    
            $user->update($validated);
    
            return response()->json([
                'message' => 'Akun berhasil diperbarui',
                'data' => $user
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data akun',
                'error' => $th->getMessage()
            ], 500);
        }
    }    

    public function destroy($id)
    {
        try {
            $user = User::find($id);
    
            if (!$user) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
    
            $user->delete();
    
            return response()->json(['message' => 'Data berhasil dihapus', 'data' => $user]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
