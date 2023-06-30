<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Doctor;


class AuthController extends Controller
{

    public function register(RegisterUserRequest $request)
    {

        $randId = rand(1, 300);

        $user = User::create([
            'name' => $request->validated('name'),
            'surname' => $request->validated('surname'),
            'slug' => Str::slug($request->validated('name') . '-' . $request->validated('surname') . '-' . $randId),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    public function login(LoginUserRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email o password non valida'
            ], 401);
        }

        $user = User::where('email', $request->validated('email'))->firstOrFail();
        DB::table('personal_access_tokens')
        ->where('tokenable_id', $user->id)
        ->delete();//rimozione vecchi access token



        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function user(Request $request)
    {
        $userID = $request->user()->id;
        $loggedDoctor = Doctor::with('reviews', 'specializations', 'subscriptions', 'messages', 'experiences')->where('user_id', $userID)->first();
        return $data = [
            'doctor' => $loggedDoctor,
            'user' => $request->user(),
        ];

    }


}
