<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Http\Request;

class UserdatachangeController extends Controller
{
    //
    public function getdata(Request $request){
        $id = $request->input('id');
        $data = DB::table('users')
        ->select(
            'users.user_name',
            'users.employer',
            'users.burean',
            'users.permission_level',
            'users.account',
            'users.password',
            'users.email',
        )
        ->where('users.id', '=', $id)
        ->get();

        return response()->json([
            'data' => $data,
        ]);
    }
    public function changedata(Request $request){
        $user_name = $request->input('user_name');
        $employer = $request->input('employer');
        $burean = $request->input('burean');
        $permission_level = $request->input('permission_level');
        $account = $request->input('account');
        $password = $request->input('password');
        $email = $request->input('email');
        
        $password = bcrypt($password);

        DB::table('users')
            ->where('users.account', '=', $account)
            ->update([
                'user_name' =>  $user_name,
                'employer' =>  $employer,
                'burean' =>  $burean,
                'permission_level' =>  $permission_level,
                'account' =>  $account,
                'password' =>  $password,
                'email' =>  $email,
            ]);
        return response()->json([
            'user_name' =>  $user_name,
            'employer' =>  $employer,
            'burean' =>  $burean,
            'permission_level' =>  $permission_level,
            'account' =>  $account,
            'password' =>  $password,
            'email' =>  $email,
        ]);
    }



}
