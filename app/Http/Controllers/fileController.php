<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class fileController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::User();
        if(!Storage::disk('pictures')->exists($user->encrypted_id)) {
            Storage::disk('pictures')->makeDirectory($user->encrypted_id);
            return "directory created";
        }
        return "directory already existed";
    }

    public function download(){
        return Storage::disk('pictures')->download('eyJpdiI6IkJoUlB6U1BZNWxSak10bU1DbFM3SHc9PSIsInZhbHVlIjoiXC9tVE43UnNEU3dLRCtCK2pYVGdlUWc9PSIsIm1hYyI6ImEzM2M3OGFlZDE3YmI2Njg3MzYzZGExODc5Y2Y3OWI2ZDcxMTMzNmZhMWNiMmUzMDE0NDJiYTdkZDdkYWVkN2YifQ==/1568530278zps05r4ezkl11.png');
    }
}
