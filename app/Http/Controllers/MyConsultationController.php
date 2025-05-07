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
            ->with(['creator'])
            ->withPivot('topic')
            ->get();
    
        // Saņēmam konsultācijas, sagrupētas pēc skolotāja
        $availableConsultationsByTeacher = [];
    
        foreach ($myConsultations as $consultation) {
            $teacherId = $consultation->creator->id ?? null;
    
            if ($teacherId) {
                $availableConsultationsByTeacher[$consultation->id] = Consultation::where('is_active', 1)
                    ->where('created_by', $teacherId)
                    ->where('id', '!=', $consultation->id) 
                    ->get();
            }
        }
    
        return view('myConsultations.index', [
            'myConsultations' => $myConsultations,
            'availableConsultationsByTeacher' => $availableConsultationsByTeacher,
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

    // Pārbauda, lai jauna konsultācija būtu pieejama
    $newConsultation = Consultation::find($request->new_consultation_id);

    if (!$newConsultation || $newConsultation->is_active == 0) {
        return back()->with('error', 'Izvēlētā konsultācija nav pieejama.');
    }

    // Pārbauda, vai jauna konsultācija jau ir pilna
    if ($newConsultation->users()->count() >= 10) {
        return back()->with('error', 'Šī konsultācija jau ir pilna (maks. 10 studenti).');
    }

    // Tekoša ieraksta dzēšana 
    $consultation->users()->detach(auth()->id());

    // User pievienošana pie jaunām konsultācijām
    $newConsultation->users()->attach(auth()->id(), ['topic' => $request->topic]);

    return redirect()->route('myConsultation.index')->with('success', 'Konsultācija veiksmīgi atjaunināta.');
}

}