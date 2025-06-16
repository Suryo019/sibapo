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
    public function index(Request $request)
    {
        Carbon::setLocale('id');
    
        $query = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.id', 'roles.role', 'users.name', 'users.username', 'users.email');
    
        if ($request->has('dinas') && $request->dinas != '') {
            $query->where('roles.role', $request->dinas);
        }
    
        $users = $query->get();
    
        $roles = DB::table('roles')->select('role')->get();
    
        return view('admin.makundinas.makundinas', [
            'title' => 'TABEL DATA AKUN',
            'data' => $users,
            'roles' => $roles
        ]);
    }
    

    public function create()
    {
        $roles = Role::all();
    
        return view('admin.makundinas.makundinas-create', [
            'title' => 'TAMBAH DATA AKUN',
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
        return view('admin.makundinas.makundinas-update',[
            'title' => 'UBAH DATA AKUN',
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy($id)
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
