<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;

class MyConsultationController extends Controller
{
    public function index()
    {
        // Получаем все консультации, на которые записан пользователь
        $myConsultations = auth()->user()->consultations()->withPivot('topic')->get();

        $availableConsultations = Consultation::where('is_active', 1)->get();

        return view('myConsultations.index', [
            'myConsultations' => $myConsultations,
            'availableConsultations' => $availableConsultations,
        ], compact('myConsultations'));
    }

    public function cancel(Request $request, $consultationId)
{
    // Получаем консультацию по ID
    $consultation = Consultation::findOrFail($consultationId);

    // Удаляем запись пользователя из консультации
    $consultation->users()->detach(auth()->id());

    // Сохраняем причину отмены в таблицу my_consultations
    $consultation->users()->updateExistingPivot(auth()->id(), ['reason' => $request->input('reason')]);

    return redirect()->route('myConsultation.index')->with('success', 'Консультация отменена. Iemesls: ' . $request->input('reason'));
}

    public function update(Request $request, Consultation $consultation)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'new_consultation_id' => 'required|exists:consultations,id',
        ]);

        // Проверка, что новая консультация доступна
        $newConsultation = Consultation::find($request->new_consultation_id);

        if (!$newConsultation || $newConsultation->is_active == 0) {
            return back()->with('error', 'Izvēlētā konsultācija nav pieejama.');
        }

        // Удаление текущей записи
        $consultation->users()->detach(auth()->id());

        // Добавление пользователя в новую консультацию
        $newConsultation->users()->attach(auth()->id(), ['topic' => $request->topic]);

        return redirect()->route('myConsultation.index')->with('success', 'Konsultācija veiksmīgi atjaunināta.');
    }

}
