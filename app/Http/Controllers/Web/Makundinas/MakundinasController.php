<?php

namespace App\Http\Controllers\Web\Makundinas;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MakundinasController extends Controller
{
    public function index()
    {

        Carbon::setLocale('id');
          
        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 'roles.role', 'users.name', 'users.username', 'users.email')
            ->get();

        return view('admin.makundinas.makundinas', [
            'title' => 'Manajemen Akun Dinas',
            'data' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::all();
    
        return view('admin.makundinas.makundinas-create', [
            'title' => 'Tambah Data',
            'roles' => $roles,
        ]);
    }
    

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.makundinas.makundinas-update', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function filter(Request $request)
    {
        //
    }

    public function detail(Request $request)
    {
        //
    }
}
