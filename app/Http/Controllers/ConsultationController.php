<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\MyConsultation; 
use App\Notifications\ConsultationUpdatedNotification;


class ConsultationController extends Controller
{
    // Konsultāciju saraksts
    public function index()
    {
        $consultations = Consultation::where('is_active', 1) // Tikai aktīvas konsultācijas
        ->whereDoesntHave('users', function ($query) {
            $query->where('user_id', auth()->id());  // Izmetam konsultācijas pie kuiram jau esot
        })
        ->get();

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
        $consultation->is_active = true;
        $consultation->created_by = auth()->id(); // Saglabā ID tekošam userim
        $consultation->save();

        return redirect('/consultations')->with('success', 'Konsultācija ir veiksmīgi izveidota!');
    }

    // Konsultācijas rādīšana
    public function show(Consultation $consultation)
    {
        if ($consultation->created_by !== auth()->id()) {
            return redirect('/consultations')->with('error', 'Jums nav tiesību skatīties studentu sarakstu.');
           }
    
        // Useru ielāde, saistītus ar konsultāciju
        $consultation->load('users'); 

        return view('consultations.show', [
            'consultation' => $consultation,
        ]);
    }

    // Konsultācijas rediģēšana
    public function edit($id)
    {
        // Parbaudam vai user ir skolotājs
        if (auth()->user()->usertype !== 'admin') {
         return redirect('/consultations')->with('error', 'Nav tiesību rediģēt šo konsultāciju.');
        }

        $consultation = Consultation::findOrFail($id);

        //Parbaudam to, vai tekošais user ir konsultācijas izveidotajs 
        if ($consultation->created_by !== auth()->id()) {
         return redirect('/consultations')->with('error', 'Jums nav tiesību rediģēt šo konsultāciju.');
        }

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
        $consultation->is_active = true;
        $consultation->save();

        foreach ($consultation->users as $student) {
            $student->notify(new ConsultationUpdatedNotification($consultation, 'updated'));
        }

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

        //Parbaudam to, vai tekošais user ir konsultācijas izveidotajs 
        if ($consultation->created_by !== auth()->id()) {
            return redirect('/consultations')->with('error', 'Jums nav tiesību dzēst šo konsultāciju.');
        }

        $consultation->delete();
        
        foreach ($consultation->users as $student) {
            $student->notify(new ConsultationUpdatedNotification($consultation, 'deleted'));
        }
        

        return redirect('/consultations')->with('success', 'Konsultācija veiksmīgi dzēsta!');
    }
   

    public function registerAndAssign(Request $request, Consultation $consultation)
{
    $request->validate([
        'topic' => 'required|string|max:255',
    ]);

    if ($consultation->is_active == 1) {
        if ($consultation->users()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Jūs jau esat pierakstīts uz šo konsultāciju!');
        }

        // Limita parbaude
        if ($consultation->users()->count() >= 10) {
            return back()->with('error', 'Šī konsultācija jau ir pilna (maks. 10 studenti).');
        }

        $consultation->users()->attach(auth()->id(), ['topic' => $request->topic]);

        return redirect()->route('myConsultation.index')->with('success', 'Jūs esat veiksmīgi pieteicies konsultācijai!');
    }

    return back()->with('error', 'Konsultācija bija aizvērta vai pabeigta!');
}



}