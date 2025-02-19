<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pdf;

class PdfController extends Controller
{
    public function generatePDF(Request $request)
    {
        // You can pass the data from your database here
        $data = [
            'employee' => [
                'name' => 'John Doe',
                'position' => 'Staff IT',
                'department' => 'Technology',
                'work_period' => '5 tahun'
            ],
            'assessor' => [
                'name' => 'Jane Smith'
            ],
            'assessment_period' => '2025',
            'assessment_date' => '2025-02-17',
            'sub_dir' => 'IT Division',
            'strengths' => 'Excellent problem-solving skills',
            'improvements' => 'Need to improve communication skills'
        ];

        $pdf = Pdf::loadView('Pdf', $data);
        
        // Optional: Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Download PDF with a specific name
        return $pdf->download('performance-assessment.pdf');
        
        // Or display in browser
        // return $pdf->stream('performance-assessment.pdf');
    }
}