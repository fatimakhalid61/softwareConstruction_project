<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api', ['except' => ['login']]);
//    }

    public function register(Request $request)
    {
        $rules = [
            'full_name' => 'required',
            'user_name' => 'unique:users|required',
            'email' => 'required|min:6|email',
            'user_type'=>'required',
            'phone' => 'required|unique:users|numeric|digits_between:10,15',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
            'gender' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->errors()->first()){
            return response()->json([
                'message' => $validator->errors()->all(),
                'status' => 422
            ],422);
        }
        DB::beginTransaction();
        try {
            User::create([
                'full_name' => $request->full_name,
                'user_name' => $request->user_name,
                'user_type' => $request->user_type,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'gender' => $request->gender
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage(),
                'data' => [],
                'status' => 500
            ], 500);
        }
        return response()->json([
            'message' => 'Success',
            'data' => [],
            'status' => 200
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->only('user_name', 'password');
        if (!$token = JWTAuth::attempt([
            'user_name'=> $request->user_name,
            'password' => $request->password
        ])) {
            return response([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ],401);
        }
        return response([
            'success' => true,
            'data' => $token,
            'user_type' => JWTAuth::user()->user_type
        ], 200);
    }
}
