<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;


class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::all();  
        return view('consultations.index', compact('consultations'));  
    }


    public function create()
    {
        return view('consultations.create');
    }

    
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'date_time' => 'required|date',  
        ]);

        
        $consultation = new Consultation();
        $consultation->date_time = $validated['date_time'];
        $consultation->save();  

        
        return redirect('/consultations')->with('success', 'Konsultācija ir veiksmīgi izveidota!');
    }


 
    public function show(Consultation $consultation)
    {
        return view('consultations.show', compact('consultation'));   
    }

    public function edit($id)
    {
        
        $consultation = Consultation::findOrFail($id);
        
        return view('consultations.edit', ['consultation' => $consultation]);
    }

  

        public function update(Request $request, $id)
{
    
    $request->validate([
        'date_time' => 'required|date',
    ]);

    
    $consultation = Consultation::findOrFail($id);

    // Apstrādā datumu, izmantojot Carbon
    $consultation->date_time = \Carbon\Carbon::parse($request->input('date_time'));

    
    $consultation->save();

    
    return redirect()->route('consultations.index')->with('success', 'Konsultācijas datu mainīšana ir veiksmīga');
}

    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultation->delete();

        return redirect('/consultations')->with('success', 'Konsultācijas dzēšana ir veiksmīga');
    }

    
public function register(Request $request, $id)
{
   
    $consultation = Consultation::findOrFail($id);

    
    Auth::user()->consultations()->attach($consultation);

    
    return redirect()->route('consultations.index')->with('success', 'Jūs esat pieteicies uz konsultāciju!');
}

}
