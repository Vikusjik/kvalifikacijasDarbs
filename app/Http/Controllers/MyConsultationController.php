<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Notifications\ConsultationCancelled;

class MyConsultationController extends Controller
{
    public function index()
    {
        // Saņēmam visas konsultācijas uz kuram ir pierakstīts user
        $myConsultations = auth()->user()->consultations()
        ->with(['creator']) // Load datus par konsultācijas izveidotāju
        ->withPivot('topic') // Pievienojam datus ni pivot tabulas
        ->get();
        $availableConsultations = Consultation::where('is_active', 1)->get();

        return view('myConsultations.index', [
            'myConsultations' => $myConsultations,
            'availableConsultations' => $availableConsultations,
        ], compact('myConsultations'));
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