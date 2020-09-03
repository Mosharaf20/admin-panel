<?php

namespace App\Http\Controllers;

use App\Notifications\UserCreateNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('logout');
    }

    public function index()
    {
        return response(User::latest()->paginate(6));
    }

  public function allUser()
    {
        return response(User::all());
    }


    public function store()
    {
        if (Gate::any(['isAdmin','isSubAdmin'])){

            $data = request()->validate([
                'name'=>'required|string|min:5|max:255',
                'email'=>'required|email|unique:users|min:5|max:255',
                'type'=>'required',
                'password'=>'required|min:6|string|min:6',
            ]);


            $user = User::create(array_merge(
                $data,
                ['password'=>Hash::make(request('password'))]
            ));

            auth('api')->user()->notify(new UserCreateNotification($user));

            return 'success';

        }
    }


    public function update(User $user,Request $request)
    {
        if (Gate::any(['isAdmin','isSubAdmin'])) {
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
    }

    public function destroy(User $user)
    {
        $this->authorize('isAdmin');

        $user->delete();
        return 'success';
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }


    public function search(Request $request)
    {

        if (  $keyword = $request->get('q')){
            $searchData = User::where(function ($query) use($keyword){
                $query->where('name','LIKE','%'.$keyword.'%')
                    ->orWhere('email','LIKE','%'.$keyword.'%')
                    ->orWhere('type','LIKE','%'.$keyword.'%')
                    ->orWhere('id','LIKE','%'.$keyword.'%');
            })->paginate(5);

        }else{
            $searchData = User::latest()->paginate(6);
        }

        return $searchData;
    }

    public function notification()
    {
        $user = auth('api')->user();
        return  $user->notifications->all();
    }


}
