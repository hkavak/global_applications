<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Log;
use Auth;
use App;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function postButton(Request $request) {
        if (Input::get('en')) {
            App::setLocale('en');
            return view('home');
        } elseif (Input::get('sv')) {
            App::setLocale('sv');
            return view('home');
        } elseif (Input::get('tr')) {
            App::setLocale('tr');
            return view('home');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        Log::info('The currently logged in person: ' . Auth::user()->first_name . Auth::user()->last_name);
        return view('home');
    }

}
