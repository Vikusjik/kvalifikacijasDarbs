<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;

class StudentController extends Controller
{
    public function showAvailableConsultations()
{
    $consultations = Consultation::with('students')->get(); // Atgriež konsultācijas ar studentiem

    return view('students.index', compact('students'));
}
        // Funkcija, lai parādītu konsultācijas tēmas ievades formu
    public function registerForm($id)
 {
     $consultation = Consultation::findOrFail($id);
     return view('students.register', compact('consultation'));
 }

        // Funkcija, lai apstrādātu konsultācijas tēmas iesniegšanu
     public function registerSubmit(Request $request, $id)
 {
     $request->validate([
         'topic' => 'required|string|max:255',
     ]);

     $consultation = Consultation::findOrFail($id);
         // Saglabāt tēmu vai reģistrāciju
     $consultation->students()->attach(auth()->id(), ['topic' => $request->topic]);

     return redirect()->route('consultations.index')->with('success', 'Jūs esat veiksmīgi pieteicies konsultācijai.');
 }
}


