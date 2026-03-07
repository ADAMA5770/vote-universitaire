<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class DocumentationController extends Controller
{
    public function pdf()
    {
        $pdf = Pdf::loadView('documentation');
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('guide-vote-universitaire.pdf');
    }
}
