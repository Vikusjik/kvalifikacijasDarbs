<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;

class StudentController extends Controller
{
    public function showAvailableConsultations()
    {
        $consultations = Consultation::with('students')->get(); // Atgriež konsultācijas ar studentiem
        
        // Izslēdz konsultācijas, kurās students jau ir pieteicies
        $consultations = $consultations->filter(function ($consultation) {
            return !$consultation->students->contains('id', auth()->id());
        });
    
        return view('students.index', compact('consultations'));  // Pārsūtīt tikai pieejamās konsultācijas
    }
    
        // Funkcija, lai parādītu konsultācijas tēmas ievades formu
    public function registerForm($id)
    {
        $consultation = Consultation::findOrFail($id);
        return view('students.register', compact('consultation'));
    }

    public function registerSubmit(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
        ]);
    
        $consultation = Consultation::findOrFail($id);
    
        // Limits - max 10 studenti
        if ($consultation->students()->count() >= 10) {
            return redirect()->back()->with('error', 'Šī konsultācija jau ir pilna (maks. 10 studenti).');
        }
    
        // Parbauda, vai nav pierakstits
        if ($consultation->students()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()->with('error', 'Jūs jau esat pierakstīts uz šo konsultāciju.');
        }
    
        $consultation->students()->attach(auth()->id(), ['topic' => $request->topic]);
    
        return redirect()->route('consultations.index')->with('success', 'Jūs esat veiksmīgi pieteicies konsultācijai.');
    }
    
    }


