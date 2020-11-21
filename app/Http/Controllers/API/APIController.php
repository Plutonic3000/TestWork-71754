<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class APIController extends Controller
{
    /*
     * PASSPORT LOGIN & REGISTER
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string|confirmed',
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status_code' => 202,
            ], 202);
        }

        $user = User::where('email', $request->email)->first();
        if(isset($user->id)) {
            return response()->json([
                'message' => 'Email already in use',
                'status_code' => 401,
            ], 401);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if($user->save()) {
            return response()->json([
                'message' => 'User created successfully',
                'status_code' => 201,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Some errors occurred, Please try again',
                'status_code' => 500,
            ], 500);
        }

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);

        if($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status_code' => 202,
            ], 202);
        }

        if(!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return response()->json([
                'message' => 'Unauthorized',
                'status_code' => 401,
            ], 401);
        }

        $user = $request->user();

        if($user->role == 'administrator') {
            $tokenData = $user->createToken('Personal Access Token', ['do_anything']);
        } else {
            $tokenData = $user->createToken('Personal Access Token', ['can_create']);
        }

        $token = $tokenData->token;

        if($request->remember_me) {
            $token->expire_at = Carbon::now()->addWeeks(1);
        }

        if($token->save()) {
            return response()->json([
                'user' => $user,
                'access_token' => $tokenData->accessToken,
                'token_type' => 'Bearer',
                'token_scope' => $tokenData->token->scopes[0],
                'expires_at' => Carbon::parse($tokenData->token->expires_at)->toDateTimeString(),
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Some errors occurred, Please try again',
                'status_code' => 500,
            ], 500);
        }

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logged out',
            'status_code' => 200
        ], 200);
    }
}
