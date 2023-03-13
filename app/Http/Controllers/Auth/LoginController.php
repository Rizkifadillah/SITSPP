<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    

    use AuthenticatesUsers;

    public function loginUrl(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        $user = Auth::loginUsingId($request->user_id);
        return redirect($request->url);
        // dd($user);
    }

    public function showLoginForm()
    {
        return view('auth.login_sneat');
    }
    public function showLoginFormWali()
    {
        return view('auth.login_sneat_wali');
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    // public function authenticated(Request $request, $user)
    // {
    //     if ($user->akses == 'operator' || $user->akses == 'admin') {
    //         return redirect()->route('operator.beranda');
    //     } elseif ($user->akses == 'wali') {
    //         return redirect()->route('wali.beranda');
    //     } else {
    //         Auth::user()->logout();
    //         flash('Anda tidak memiliki hak akses')->error();
    //         return redirect()->route('login');
    //     }
    // }
    public function redirectTo()
    {
        switch(Auth::user()->akses){
            case 'admin':
            $this->redirectTo = route('admin.beranda');;
            return $this->redirectTo;
                break;
            case 'operator':
                $this->redirectTo = route('operator.beranda');;
                return $this->redirectTo;
                break;
            case 'wali':
                $this->redirectTo = route('wali.beranda');;
                return $this->redirectTo;
                break;
            default:
                $this->redirectTo = '/login';
                return $this->redirectTo;
        }
         
        // return $next($request);
    } 

}
