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
use Illuminate\Support\Carbon;
use App\Models\Doctor;


class AuthController extends Controller
{

    public function register(RegisterUserRequest $request)
    {

        $randId = rand(1, 300);
//creazione user
        $user = User::create([
            'name' => $request->validated('name'),
            'surname' => $request->validated('surname'),
            'slug' => Str::slug($request->validated('name') . '-' . $request->validated('surname') . '-' . $randId),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);
//creazione Doctor e assegnazione dati della registrazione
       $doctor = new Doctor();
       $doctor->user_id = $user->id;
       $doctor->slug = $user->slug;
       $doctor->address = $request->validated('address');
       $doctor->city = $request->validated('city');
       $doctor->address_lat = $request->validated('lat');
       $doctor->address_long = $request->validated('long');
       if ($request->validated('phone')) {
        $doctor->phone = $request->validated('phone');
       }
       $doctor->save();
       $doctor->specializations()->attach($request->validated('specialization'));



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
        $loggedDoctor = Doctor::with(['reviews', 'specializations', 'subscriptions' => function ($query) {
            $query->where('end_date', '>', Carbon::now());}, 'messages', 'experiences'])->where('user_id', $userID)->first();

        if ($loggedDoctor->subscriptions->count() != 0) {

            $premiumData = [
                'premium' => true,
                'days' => $loggedDoctor->subscriptions[0]->name,
            ];}
            else {
                $premiumData = [
                    'premium' => false
                ];
            }

        $loggedDoctor->subscription = $premiumData;

        return $data = [
            'doctor' => $loggedDoctor,
            'user' => $request->user(),
        ];

    }

    public function logout(Request $request) {
      $userID = $request->user()->id;
      DB::table('personal_access_tokens')
        ->where('tokenable_id', $userID)
        ->delete();

        return response()->json([
            'status' => 'logged out'
        ]);
    }


}
