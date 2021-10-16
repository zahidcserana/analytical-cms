<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
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
        $user = User::create([
            'id' => 1,
            'name' => 'Analytical Journey',
            'email' => 'cms@analytical.com',
            'password' => Hash::make('secret'),
            'observe' => Carbon::now()->addMonths(12),
            'type' => User::ROLE_ADMINISTRATOR,
        ]);

        $user = User::create([
            'id' => 1,
            'name' => 'Analytical Journey',
            'email' => 'admin@analytical.com',
            'password' => Hash::make('aj$21'),
            'observe' => Carbon::now()->addMonths(12),
            'type' => User::ROLE_ADMINISTRATOR,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
