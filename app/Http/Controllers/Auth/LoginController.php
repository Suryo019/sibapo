<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    protected function redirectTo()
    {
        $role = Auth::user()->role->role;

        return match ($role) {
            'admin' => '/dashboard',
            'pimpinan' => '/pimpinan/dashboard',
            'disperindag' => '/pegawai/disperindag/dashboard',
            'dkpp' => '/pegawai/dkpp/dashboard',
            'dtphp' => '/pegawai/dtphp/dashboard',
            'perikanan' => '/pegawai/perikanan/dashboard',
            default => '/',
        };
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
