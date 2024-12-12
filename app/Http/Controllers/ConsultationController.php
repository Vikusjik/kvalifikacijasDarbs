<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\MyConsultation; 

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
    
        // Useru ielāde, saistītus ar konsultāciju
        $consultation->load('users'); 

        return view('consultations.show', [
            'consultation' => $consultation,
        ]);
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
        $consultation->is_active = true;
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

    public function registerAndAssign(Request $request, Consultation $consultation)
    {
        // Tēmas validācija
        $request->validate([
            'topic' => 'required|string|max:255',
        ]);
    
       
        if ($consultation->is_active == 1) {  // Parbaudam vai konsultācija ir aktīva
            // Parbaudam vai user ir jau piekastits uz konsultaciju
            if ($consultation->users->contains('id', auth()->id())) {
                return back()->with('error', 'Jūs jau esat pierakstīts uz šo konsultāciju!');
            }
    
            // Pieveino ierakstu tabulā my_consultations ar temu
            $consultation->users()->attach(auth()->id(), ['topic' => $request->topic]);
    
            return redirect()->route('myConsultation.index')->with('success', 'Jūs esat veiksmīgi pieteicies konsultācijai!');
        }
    
        return back()->with('error', 'Konsultācija bija aizvērta vai pabeigta!');
    }
   


}