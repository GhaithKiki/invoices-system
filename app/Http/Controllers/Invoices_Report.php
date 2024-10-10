<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class Invoices_Report extends Controller
{
    function __construct()
    {
        $this->middleware('permission:تقرير الفواتير', ['only' => ['index']]);
    }

    public function index()
    {
        return view('reports.invoices_report');
    }

    public function Search_invoice(Request $request)
    {
        $rdio = $request->rdio;
        $invoices = collect(); // إنشاء مجموعة فارغة
        $type = null; // تعريف المتغير بقيمة افتراضية
        $start_at = null; // تعريف المتغير بقيمة افتراضية
        $end_at = null; // تعريف المتغير بقيمة افتراضية
    
        if ($rdio == 1) {
            // تحقق إذا كان هناك نوع
            if ($request->type) {
                $type = $request->type; // تعيين قيمة نوع الفاتورة
                $start_at = $request->start_at ? date('Y-m-d', strtotime($request->start_at)) : null;
                $end_at = $request->end_at ? date('Y-m-d', strtotime($request->end_at)) : null;
    
                if ($start_at && $end_at) {
                    $invoices = invoices::whereBetween('invoice_Date', [$start_at, $end_at])
                                        ->where('Status', $type)->get();
                } else {
                    $invoices = invoices::where('Status', $type)->get();
                }
            }
        } else {
            // بحث برقم الفاتورة
            if ($request->invoice_number) {
                $invoices = invoices::where('invoice_number', $request->invoice_number)->get();
            }
        }
    
        return view('reports.invoices_report', compact('invoices', 'type', 'start_at', 'end_at'));
    }
    
}