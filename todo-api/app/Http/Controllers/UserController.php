<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewUser;
use App\Actions\GenerateAuthToken;
use App\Models\User;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiResponse::forbidden();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $emailRule = 'email:rfc';
        if (! app()->environment('testing')) {
            $emailRule .= ',dns';
        }

        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', $emailRule, 'min:3', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = (new CreateNewUser($request->name, $request->email, $request->password))->execute();
        $token = (new GenerateAuthToken($user))->execute();

        return ApiResponse::created(['user' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string|int $id)
    {
        $user = User::find((int) $id);

        return is_null($user) ? ApiResponse::notFound() : ApiResponse::ok(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // For now
        return ApiResponse::forbidden();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // For now until we need it
        return ApiResponse::forbidden();
    }
}
