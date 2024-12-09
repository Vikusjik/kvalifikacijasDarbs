<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;

class ConsultationController extends Controller
{
    
    // Konsultāciju saraksts
    public function index()
    {
        $consultations = Consultation::all();  
        return view('consultations.index', compact('consultations'));  
    }

    // Jaunas konsultācijas izveide
    public function create()
    {
        // Pārbaudām, vai lietotājs ir skolotājs
        if (auth()->user()->usertype !== 'admin') {
            return redirect('/consultations')->with('error', 'Nav tiesību izveidot konsultācijas.');
        }

        return view('consultations.create');
    }

    // Konsultācijas saglabāšana
    public function store(Request $request)
    {
        // Validācija
        $validated = $request->validate([
            'date_time' => 'required|date',
        ]);

        $consultation = new Consultation();
        $consultation->date_time = $validated['date_time'];
        $consultation->save();

        return redirect('/consultations')->with('success', 'Konsultācija ir veiksmīgi izveidota!');
    }

    // Konsultācijas rādīšana
    public function show(Consultation $consultation)
    {
        return view('consultations.show', compact('consultation'));   
    }

    // Konsultācijas rediģēšana
    public function edit($id)
    {
        // Pārbaudām, vai lietotājs ir skolotājs
        if (auth()->user()->usertype !== 'admin') {
            return redirect('/consultations')->with('error', 'Nav tiesību rediģēt šo konsultāciju.');
        }

        $consultation = Consultation::findOrFail($id);
        return view('consultations.edit', ['consultation' => $consultation]);
    }

    // Konsultācijas atjaunināšana
    public function update(Request $request, $id)
    {
        // Validācija
        $request->validate([
            'date_time' => 'required|date',
        ]);

        // Pārbaudām, vai lietotājs ir skolotājs
        if (auth()->user()->usertype !== 'admin') {
            return redirect('/consultations')->with('error', 'Nav tiesību mainīt šo konsultāciju.');
        }

        $consultation = Consultation::findOrFail($id);
        $consultation->date_time = \Carbon\Carbon::parse($request->input('date_time'));
        $consultation->save();

        return redirect()->route('consultations.index')->with('success', 'Konsultācija veiksmīgi atjaunināta!');
    }

    // Konsultācijas dzēšana
    public function destroy($id)
    {
        // Pārbaudām, vai lietotājs ir skolotājs
        if (auth()->user()->usertype !== 'admin') {
            return redirect('/consultations')->with('error', 'Nav tiesību dzēst šo konsultāciju.');
        }

        $consultation = Consultation::findOrFail($id);
        $consultation->delete();

        return redirect('/consultations')->with('success', 'Konsultācija veiksmīgi dzēsta!');
    }
}
