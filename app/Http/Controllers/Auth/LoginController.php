<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $title = __('login');
        return view('auth.login',compact('title'));
    }
    public function login(Request $request)
    {
        try {
            $request->validate(
                [
                    $this->username() => 'required|string',
                    'password' => 'required|string',
                ]);
            if (
                method_exists($this, 'hasTooManyLoginAttempts') &&
                $this->hasTooManyLoginAttempts($request)
            ) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }
            if ($this->attemptLogin($request)) {
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }
                return $this->sendLoginResponse($request);
            }
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed !!',
                'data' => [
                    'error' => (config('app.debug')) ? $th->getMessage() : __("server_error")
                ]
            ], 500);
        }
    }
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse(["message" => "Berhasil Masuk, mohon tunggu sebentar ...", "redirect" => $this->redirectPath()], 200)
            : redirect()->intended($this->redirectPath());
    }

}
