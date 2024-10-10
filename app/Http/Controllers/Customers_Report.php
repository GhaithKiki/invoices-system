<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sections;
use App\Models\invoices;
class Customers_Report extends Controller
{
    function __construct()
    {
        $this->middleware('permission:تقرير العملاء', ['only' => ['index']]);
    }
    public function index(){

      $sections = sections::all();
      return view('reports.customers_report',compact('sections'));
        
    }


    public function Search_customers(Request $request)
    {
        // التحقق من المدخلات
        $request->validate([
            'Section' => 'required|exists:sections,id',
            'product' => 'required|string',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
        ]);
    
        $query = invoices::query();
    
        // تطبيق الفلاتر بناءً على المدخلات
        $query->where('section_id', $request->Section)
              ->where('product', $request->product);
    
        // في حالة وجود تاريخ
        if ($request->filled('start_at') && $request->filled('end_at')) {
            $query->whereBetween('invoice_Date', [$request->start_at, $request->end_at]);
        }
    
        $invoices = $query->get();
        $sections = sections::all();
    
        // استخدام compact لتمرير المتغيرات
        return view('reports.customers_report', compact('sections', 'invoices'))->with('details', $invoices);
    }
    
}