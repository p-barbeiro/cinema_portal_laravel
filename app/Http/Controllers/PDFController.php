<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{

    public function generateReceipt()
    {
        $data = [
            'title' => 'Welcome to Laravel Tinker',
            'date' => date('m/d/Y'),
        ];

        $pdf = Pdf::loadView('pdf.receipt', $data);
        return $pdf->download('invoice.pdf');

    }
}
