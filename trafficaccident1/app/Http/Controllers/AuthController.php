<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('users')
            ->select(
                'users.id',
                'users.user_name',
                'users.account',
                'users.created_at'
            )
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'user_name' => 'required|max:55',
            'employer' => 'required|max:55',
            'burean' => 'required|max:55',
            'permission_level' => 'required|max:55',
            'account' => 'required|max:55|unique:users',
            'password' => 'required|confirmed',
            'email' => 'string|nullable',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        return response([
            'status' => 'Success',
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'account' => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $expiration = auth()->user()->createToken('authToken')->token->expires_at->diffForHumans();

        Session::put('accessToken', $accessToken);
        
        return response([
            'status' => 'Success',
            'user' => auth()->user(),
            'access_token' => $accessToken,
            'expires_at' => $expiration,
        ]);

    }

    public function logout()
    {
        if (Auth::check()) {

            Auth::user()->token()->revoke();

            Session::flush();

            return response([
                'status' => 'Success',
            ]);

        } else {

            return response([
                'status' => 'Error',
            ]);

        }


    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
