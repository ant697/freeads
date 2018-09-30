<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Mail;
//use Illuminate\Support\Facades\Mail;
use App\Mail\DemoMail;

use Illuminate\Support\Facades\Mail;
//use App\Http\Controllers\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('home');

//        $email = 'antoine.guerra@epitech.eu';
////        $email = Auth::user()->email;
//        Mail::to($email)->send(new DemoMail());
        return view('home');
    }
}
