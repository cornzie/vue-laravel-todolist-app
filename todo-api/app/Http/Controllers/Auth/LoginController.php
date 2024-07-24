<?php

namespace App\Http\Controllers\Auth;

use App\Actions\GenerateAuthToken;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return ApiResponse::unauthorized('email or password is incorrect');
        }

        return ApiResponse::ok([
            'user' => $user,
            'api_token' => (new GenerateAuthToken($user))->execute(),
        ], [
            'api_token' => (new GenerateAuthToken($user))->execute(),
        ]);

    }
}
