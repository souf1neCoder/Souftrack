<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Traits\HttpResponses;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use HttpResponses;
    public function __construct(private AuthService $authService)
    {
    }
    public function register(UserRequest $request)
    {
        return $this->authService->registreTransact($request);
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Models\User */
            $user = Auth::user();
            $token = $user->createToken('api token ' . $user->fullname)->plainTextToken;
            Log::info("Token " . $token);
            return $this->handleResponse($token, 'User login successfully', 200);
        }


        return $this->handleError(['Incorrect Email or Password'], 400);
    }
    //
    //
    //
    public function logout(Request $request)
    {
        // User::find($request->user()->id)->tokens()->delete();
        // Revoke the user's token
        // Clear the user's session data
        Log::info($request?->user()?->id);
        Log::info(Auth::user());
        Log::info(auth('sanctum')->user());
        DB::table('personal_access_tokens')->where('tokenable_id',$request?->user()?->id)->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return $this->handleResponse($msg = "You are Logout now!");
    }
    //
    public function me(Request $request)
    {
        $user = Auth::user();
        $account = $user->account;
        Log::info(json_encode($account));
        return $this->handleResponse($result = compact('user', 'account'));
    }
    //

}
