<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

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
        //$config = Config::get('paystack.publicKey'); another way
        $config = getenv('PAYSTACK_PUBLIC_KEY');
        return view('home', ['config' => $config]);
    }
}
