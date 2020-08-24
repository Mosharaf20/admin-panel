<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function admin()
    {
        return view('layouts.master');
    }


    public function index()
    {
        $user = User::latest()->get();
        return $user;
    }


    public function store()
    {
        $data = request()->validate([
            'name'=>'required|string|min:5|max:255',
            'email'=>'required|email|unique:users|min:5|max:255',
            'type'=>'required',
            'password'=>'required|min:6|string|min:6',
        ]);

        User::create(array_merge(
            $data,
            ['password'=>Hash::make(request('password'))]
        ));

        return 'success';
    }


    public function update(User $user,Request $request)
    {
        $data = request()->validate([
            'name'=>'required|string|min:5|max:255',
            'email'=>'required|min:5|max:255|unique:users,email,'.$user->id,
            'type'=>'required',
            'password'=>'sometimes|min:6|string|min:6',
        ]);

        if(!empty($request->password))
        {
            $password =Hash::make($request['password']);
        }

        $user->update(array_merge($data,['password'=>$password ?? $user->password]));


        return 'success';

    }

    public function destroy(User $user)
    {
        $user->delete();
        return 'success';
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }


}
