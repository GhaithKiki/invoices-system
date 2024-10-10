<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;
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
        $count_all = invoices::count();
        $count_invoices1 = invoices::where('Value_Status', 1)->count() ?? 0;
        $count_invoices2 = invoices::where('Value_Status', 2)->count() ?? 0;
        $count_invoices3 = invoices::where('Value_Status', 3)->count() ?? 0;
    
        $nspainvoices1 = $count_invoices1 == 0 ? 0 : $count_invoices1 / $count_all * 100;
        $nspainvoices2 = $count_invoices2 == 0 ? 0 : $count_invoices2 / $count_all * 100;
        $nspainvoices3 = $count_invoices3 == 0 ? 0 : $count_invoices3 / $count_all * 100;
    
        return view('home', compact('nspainvoices1', 'nspainvoices2', 'nspainvoices3'));
    }
    

}