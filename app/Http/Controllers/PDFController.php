<?php

namespace App\Http\Controllers;

use App\Models\contribuable;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function generatePDF(contribuable $contri)
    {
          
        $pdf = PDF::loadView('myPDF', compact('contri'));
    
        return $pdf->stream();
        // return $pdf->download('itsolutionstuff.pdf');
    }
}
