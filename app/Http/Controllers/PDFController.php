<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ToMill;
use App\Models\Rice;
use App\Models\Darak;
use \Barryvdh\DomPDF\Facade\Pdf as PDF;

class PDFController extends Controller
{
    public function getAllPalay()
    {
        $products = Product::all();
        $mill = ToMill::all();
        $rice = Rice::all();
        $darak = Darak::all();
        return view('pdf',compact('products', 'mill', 'rice', 'darak'));
    }

    public function downloadPDF()
    {
        $products = Product::all();
        $mill = ToMill::all();
        $rice = Rice::all();
        $darak = Darak::all();
        $pdf = PDF::loadview('pdf',compact('products', 'mill', 'rice', 'darak'));
        return $pdf->stream('product-reports.pdf');
    }

}
