<?php

namespace App\Http\Controllers;

use App\Models\invoices_details;
use App\Models\invoices_attachments;
use App\Models\invoices;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

        public function download($invoice_number,$file_name)

    {
       
        $filePath = public_path('Attachments/' . $invoice_number . '/' . $file_name);

        return response()->download($filePath);
        
        
    }
    

    
public function show($invoice_number, $file_name)
{
    $filePath = public_path('Attachments/' . $invoice_number . '/' . $file_name);

    // Check if the file exists
    if (!file_exists($filePath)) {
        abort(404);
    }

    // Get the MIME type of the file
    $mime_type = mime_content_type($filePath);

    return response()->stream(function () use ($filePath, $mime_type) {
        $file = fopen($filePath, 'r');
        $headers = [
            'Content-Type' => $mime_type,
            'Content-Length' => filesize($filePath),
        ];

        foreach ($headers as $header => $value) {
            echo $header . ': ' . $value . "\n";
        }

        fpassthru($file);
    }, 200);


}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoices::where('id',$id)->first();
        $details = invoices_details::where('id_Invoice',$id)->get();
        $attachments = invoices_attachments::where('invoice_id',$id)->get();
        return view('invoices.details_invoices',compact('invoices','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $invoices = invoices_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }


 



}
