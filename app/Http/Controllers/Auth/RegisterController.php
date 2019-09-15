<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required'],
            'state' => ['required'],
            'image' => ['required', 'image'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $saved_data = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'country' => $data['country'],
            'state' => $data['state'],
        ]);
        $this->encID($saved_data);
        $this->fileSys($saved_data);
        $this->image($saved_data, $data);
        
        return $saved_data;
    }

    public function encID($newUserInstance){
        $newUserInstance->fill([
            'encrypted_id' => encrypt($newUserInstance->id),
        ])->save();
    }

    public function fileSys($newUserInstance){
        if(!Storage::disk('pictures')->exists($newUserInstance->encrypted_id)) {
            Storage::disk('pictures')->makeDirectory($newUserInstance->encrypted_id);
        }
    }

    public function image($newUserInstance, $data){
        $image_name = time(). $data['image']->getClientOriginalName();
        $store = $data['image']->storeAs(
            $newUserInstance->encrypted_id, $image_name, 'pictures'
        );
        $newUserInstance->fill([
            'image' => $image_name,
        ])->save();
    }
}
