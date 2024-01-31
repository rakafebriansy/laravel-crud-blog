<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }
    public function store(Request $request) //mengambil request dengan instansiasi object request
    {
        //laravel validation doc in https://laravel.com/docs/10.x/validation#available-validation-rules
        $validated = $request->validate([ //delimiter menggunakan | atau array
            'name' => 'required|max:255',
            'username' => ['required','min:3','max:255','unique:users'],
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255',
        ]); //melakukan validasi terhadap post request
        $validated['password'] = Hash::make($validated['password'],[
            'rounds' => 12,
        ]);
        User::create($validated);

        // $request->session()->flash('success', 'Registration was successful! Please login.'); //membuat flash data pada session untuk flash message

        return redirect('/login')->with('success', 'Registration was successful! Please login.'); //cara lain membuat flash data pada session
    }
}
