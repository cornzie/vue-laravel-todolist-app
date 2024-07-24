<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
        } catch (\Throwable $th) {
            report($th);

            return ApiResponse::serverError();
        }

        return ApiResponse::noContent();
    }
}
