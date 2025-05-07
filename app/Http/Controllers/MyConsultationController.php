<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Notifications\ConsultationCancelled;

class MyConsultationController extends Controller
{
    public function index()
    {
        $myConsultations = auth()->user()->consultations()
            ->with(['creator']) // Skolotāja dati
            ->withPivot('topic')
            ->get();
    
        // Iegūst visas pieejamās konsultācijas
        $availableConsultations = Consultation::where('is_active', 1)->get()->groupBy('creator_id');
    
        return view('myConsultations.index', [
            'myConsultations' => $myConsultations,
            'availableConsultations' => $availableConsultations, // Grupēts pēc skolotāja
        ]);
    }
    

public function cancel(Request $request, $consultationId)
{
    $consultation = Consultation::findOrFail($consultationId);

    // Saglābājam atteikšanas iemeslu (pirms dzēšanas!)
    $consultation->users()->updateExistingPivot(auth()->id(), [
        'reason' => $request->input('reason')
    ]);

    //Noņemam studentu no konsultacijas
    $consultation->users()->detach(auth()->id());

    // Saņemam skolotāju
    $teacher = $consultation->creator;

    // Sūtam paziņojumu
    $teacher->notify(new ConsultationCancelled(
        $consultation,
        $request->input('reason'),
        auth()->user()
    ));

    return redirect()->route('myConsultation.index')
        ->with('success', 'Konsultācija ir atcēlta. Iemesls: ' . $request->input('reason'));
}


    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'new_consultation_id' => 'required|exists:consultations,id',
        ]);

        // Pārbauda, lai jauna konsultācija būdu pieejama
        $newConsultation = Consultation::find($request->new_consultation_id);

        if (!$newConsultation || $newConsultation->is_active == 0) {
            return back()->with('error', 'Izvēlētā konsultācija nav pieejama.');
        }

        // Tekoša ieraksta dzēšana 
        $consultation->users()->detach(auth()->id());

        // User pievienošana pie jaunam konsultācijam
        $newConsultation->users()->attach(auth()->id(), ['topic' => $request->topic]);

        return redirect()->route('myConsultation.index')->with('success', 'Konsultācija veiksmīgi atjaunināta.');
    }

}