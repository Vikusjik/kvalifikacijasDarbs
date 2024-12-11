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
        $consultations = Consultation::where('is_active', 1) // Отбираем только активные консультации
        ->whereDoesntHave('users', function ($query) {
            $query->where('user_id', auth()->id());  // Исключаем консультации, на которые уже записан текущий пользователь
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
        $consultation->save();

        return redirect('/consultations')->with('success', 'Konsultācija ir veiksmīgi izveidota!');
    }

    // Konsultācijas rādīšana
    public function show(Consultation $consultation)
    {
    
        // Загрузка пользователей, связанных с консультацией, и их тем
        $consultation->load('users'); // Предполагается, что у вас есть связь `users` в модели Consultation

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
        // Валидация темы консультации
        $request->validate([
            'topic' => 'required|string|max:255',
        ]);
    
        // Проверка, активна ли консультация
        if ($consultation->is_active == 1) {  // Проверка на активность консультации
            // Проверяем, записан ли уже пользователь на консультацию
            if ($consultation->users->contains('id', auth()->id())) {
                return back()->with('error', 'Вы уже записаны на эту консультацию!');
            }
    
            // Добавление записи в таблицу my_consultations с темой
            $consultation->users()->attach(auth()->id(), ['topic' => $request->topic]);
    
            return redirect()->route('myConsultation.index')->with('success', 'Вы успешно записались на консультацию!');
        }
    
        return back()->with('error', 'Консультация была закрыта или завершена!');
    }
   


}
