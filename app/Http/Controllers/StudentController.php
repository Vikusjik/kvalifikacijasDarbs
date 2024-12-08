<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function showAvailableConsultations()
{
    $consultations = Consultation::with('students')->get(); // Atgriež konsultācijas ar studentiem

    return view('students.index', compact('students'));
}

}
