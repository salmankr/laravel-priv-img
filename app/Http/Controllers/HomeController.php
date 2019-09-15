<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::User();
        $enc_id = $user->encrypted_id;
        $img_name = $user->image;
        $url = route('image', ['directory' => $enc_id, 'name' => $img_name]);
        return view('home', compact('url'));
    }

    public function imgShow($directory, $image){
        return Storage::disk('pictures')->download($directory. '/' .$image);
    }
}
