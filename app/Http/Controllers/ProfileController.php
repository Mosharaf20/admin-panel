<?php

namespace App\Http\Controllers;

use App\User;
use Defuse\Crypto\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        return auth('api')->user();
    }

    public function store(User $user)
    {
        $data = request()->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$user->id,
            'password'=>'sometimes|required',
        ])  ;

        if(!empty(request('password'))){
            $password = bcrypt(request('password'));
        }

        $user->update(array_merge($data,['password'=>$password ?? $user->password ]));
        return  'Successfully Updated';
    }

    public function profileImage(Request $request)
    {
        $data = $this->validate($request,[
            'image'=>'required'
        ]);

        if($request->has('image')){
            $image = time().'.'.explode('/',substr($request->image,0,strpos($request->image,';')))[1];

//            $test = explode(',' , $request->image)[1];
//            $decode = base64_decode($test);
//            $path = public_path('images/admin/profiles/').$image;
//            file_put_contents($path,$decode);

            $user = auth('api')->user();
            if(!empty($user->image)){
                @unlink('images/admin/profiles/'.$user->image);
            }

            Image::make($request->image)->save(public_path('images/admin/profiles/'.$image));
            $user->update(['image'=>$image]);
        }

        return  $user;
    }

    public function profile(Request $request)
    {
        $data = $request->validate([
           'country'=>'required',
           'description'=>'required',
           'experience'=>'required',
        ]);

        auth('api')->user()->profile()->create(request()->all());
        return   'success';
    }

}
