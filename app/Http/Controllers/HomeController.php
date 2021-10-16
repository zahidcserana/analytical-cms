<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class HomeController extends Controller
{
    public function welcome()
    {
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function clear(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('customers')->truncate();
        DB::table('invoice_items')->truncate();
        DB::table('invoices')->truncate();
        DB::table('users')->truncate();
        DB::table('payments')->truncate();

        $seeder = new UserSeeder();

        $seeder->run();


        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function heroku(Request $request)
    {
        DB::table('customers')->truncate();
        DB::table('invoice_items')->truncate();
        DB::table('invoices')->truncate();
        DB::table('users')->truncate();
        DB::table('payments')->truncate();

        $seeder = new UserSeeder();

        $seeder->run();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
