<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class HomeController extends Controller
{
    public function welcome()
    {
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
