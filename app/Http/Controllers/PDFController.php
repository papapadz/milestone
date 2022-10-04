<?php

namespace App\Http\Controllers;

use App\Models\Rice;
use App\Models\Darak;
use App\Models\ToMill;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller
{
    public function getAllPalay()
    {
        $user = Auth::user();

        $employee = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])->where('user_id', $user->id)->first();
        
        $products = Product::where('company_id', $employee->company_id)->get();
        $mill = ToMill::where('company_id', $employee->company_id)->get();
        $rice = Rice::where('company_id', $employee->company_id)->get();
        $darak = Darak::where('company_id', $employee->company_id)->get();
        return view('pdf',compact('products', 'mill', 'rice', 'darak'));
    }

    public function downloadPDF()
    {
        $user = Auth::user();

        $employee = Employee::with([
            'company'=>function($q){
                $q->select('id', 'name');
            }
        ])->where('user_id', $user->id)->first();

        $products = Product::where('company_id', $employee->company_id)->get();
        $mill = ToMill::where('company_id', $employee->company_id)->get();
        $rice = Rice::where('company_id', $employee->company_id)->get();
        $darak = Darak::where('company_id', $employee->company_id)->get();
        $pdf = PDF::loadview('pdf',compact('products', 'mill', 'rice', 'darak'));
        return $pdf->stream('product-reports.pdf');
    }

}
