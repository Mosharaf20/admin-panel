<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class GalleryController extends Controller
{
    public function index()
    {
        $images = Gallery::latest()->get();
        return $images;
    }

    public function store()
    {
        $images = Collection::wrap(request()->file('file'));

        if(!is_dir(public_path('/Gallery'))){
            mkdir(public_path('/Gallery'), 0777);
        }

        if(!is_dir(public_path('/Gallery/thumbnail'))){
            mkdir(public_path('/Gallery/thumbnail'), 0777);
        }

        $images->each(function ($image){
            $baseName =Str::random(10);
            $imageName = $baseName.'.'.$image->getClientOriginalExtension();
            $thumbnail = $baseName.'thumb'. '.' .$image->getClientOriginalExtension();

            Image::make($image)->fit(1420,800)->save(public_path('/Gallery/'.$imageName));
            Image::make($image)->fit(300,300)->save(public_path('/Gallery/'.$thumbnail));

//          $image->move(public_path('/Gallery'), $imageName);

            Gallery::create([
                'image'=> '/Gallery/'.$imageName,
                'image_thumbnail'=> '/Gallery/'.$thumbnail,
            ]);
        });

        return 'success';
    }

    public function destroy(Gallery $gallery)
    {
        File::delete([
            public_path($gallery->image),
            public_path($gallery->image_thumbnail),
        ]);

        $gallery->delete();

        return 'success';
    }
}
