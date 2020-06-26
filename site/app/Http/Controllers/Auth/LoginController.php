<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;
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
    protected $redirectTo = '/area-restrita';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'usuario';
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'senha' => 'required|string',
        ]);

        $login = Clientes::where(['usuario' => $request->input('usuario'), 'senha' => $request->input('senha')])->first();
        if ($login) {
            Auth::login($login);
        }

        return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
    }

}
