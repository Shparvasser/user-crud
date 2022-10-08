<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();

        return response($user, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (User::where('email', $request->email)->first())
            return response(['error' => 'There is already a user with this email'], Response::HTTP_BAD_REQUEST);

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response(['user' => $newUser],Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::find($id);

        if (!$user)
            return response(['error' => 'Dont have this User'],Response::HTTP_NOT_FOUND);

        return response(['user' => $user],Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, int $id)
    {
        $user = User::find($id);
        $fields = $request->json()->all();

        if ($user)
            $user->update([
                'name' => $fields['name'] ?? $user->name,
                'email' => $fields['email'] ?? $user->email,
                'password' => Hash::make(($fields['password'] ?? $user->password)),
            ]);

        return $user
            ? response('User updated', Response::HTTP_OK)
            : response(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        }

        return $user
            ? response( 'User Deleted Successfully!!',Response::HTTP_OK)
            : response( ['error' => 'User not found'],Response::HTTP_NOT_FOUND);
    }
}
