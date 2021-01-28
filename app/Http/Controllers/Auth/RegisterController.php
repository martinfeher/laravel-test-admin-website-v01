<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/register';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $validation_rules = [
            'meno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'heslo' => ['required', 'string', 'min:8', 'case_diff', 'symbols', 'confirmed'],
            'rola' => ['required'],
        ];

        $validation_messages = [
            'required' => ':attribute je potrebné vyplniť',
            'max' => ':attribute musí mať maximálne :max symboly',
            'min' => ':attribute musí mať minimálne :min symboly',
            'unique' => ':attribute je už registrovaný ',
            'confirmed' => 'Potvrdené heslo musí byť rovnaké ako heslo',
            'symbols' => ':attribute musí mať minimálne jeden špeciálny symbol',
//            'symbols' => ':attribute musí mať minimálne jeden špeciálny symbol" .,#@!+-%&()_',
        ];

        return Validator::make($data, $validation_rules, $validation_messages);


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        return User::create([
            'meno' => $data['meno'],
            'email' => $data['email'],
            'password' => Hash::make($data['heslo']),
            'rola' => $data['rola'],
        ]);
    }
}
