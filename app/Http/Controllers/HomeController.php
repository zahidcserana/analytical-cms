<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Purchase;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function dashboard()
    {
        $period = now()->subMonths(12)->monthsUntil(now());
        $title = [];
        foreach ($period as $date) {
            $title[] = $date->shortMonthName . '-' . $date->year;
        }

        $dataSale = $this->getSaleData();
        $dataPurchase = $this->getPurchaseData();
        $sales = [];
        $purchases = [];
        foreach ($title as $aTitle) {
            $sales[] = $dataSale[$aTitle] ?? 0;
            $purchases[] = $dataPurchase[$aTitle] ?? 0;
        }

        $customerCollection = Customer::where('status', Customer::STATUS_ACTIVE)->orderByDesc('balance')->get();
        $invoiceCollection = Invoice::orderByDesc('total')->get();

        $data = [
            'topCustomers' => $customerCollection->take(5),
            'topInvoices' => $invoiceCollection->take(5),
            'dueInvoiceCount' => $invoiceCollection->where('status', Invoice::STATUS_DUE)->count(),
            'invoiceCount' => $invoiceCollection->count(),
            'dueAmount' => $invoiceCollection->sum->dueTotal(),
            'customerDue' => $customerCollection->sum('balance'),
            'customerCount' => $customerCollection->count(),
            'chartData' => json_encode([
                'month' => $title,
                'sale' => $sales,
                'purchase' => $purchases
            ])
        ];

        return view('dashboard', $data);
    }

    public function getPurchaseData()
    {
        $purchaseData = Purchase::whereDate('created_at', '>', now()->subYear())->select(DB::raw('sum(total) as total'), DB::raw('YEAR(created_at) year'), DB::raw('MONTH(created_at) month'))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();

        $dataPurchase = [];
        foreach ($purchaseData as $row) {
            $row->total = $row->total == null ? 0 : (int)$row->total;
            $row->title = $this->monthName[$row->month] . '-' . $row->year;
            $dataPurchase[$row->title] = $row->total;
        }

        return $dataPurchase;
    }

    public function getSaleData()
    {
        $saleData = Invoice::whereDate('created_at', '>', now()->subYear())->select(DB::raw('sum(total) as total'), DB::raw('YEAR(created_at) year'), DB::raw('MONTH(created_at) month'))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->get();

        $dataSale = [];
        foreach ($saleData as $row) {
            $row->total = $row->total == null ? 0 : (int)$row->total;
            $row->title = $this->monthName[$row->month] . '-' . $row->year;
            $dataSale[$row->title] = $row->total;
        }

        return $dataSale;
    }

    public function clear(Request $request)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('customers')->truncate();
        DB::table('invoice_items')->truncate();
        DB::table('invoices')->truncate();
        DB::table('users')->truncate();
        DB::table('payments')->truncate();
        DB::table('expenses')->truncate();
        DB::table('purchase_items')->truncate();
        DB::table('purchases')->truncate();

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
            'id' => 2,
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
