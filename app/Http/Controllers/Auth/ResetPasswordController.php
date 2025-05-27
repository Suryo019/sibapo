<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
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
}
