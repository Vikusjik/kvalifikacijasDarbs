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
        $request->validate([
            'title' => 'required',
        ]);

        Consultation::create([
            'title' => $request->input('title'),
        ]);

        return redirect('/consultations')->with('success', 'Konsultācija ir veiksmīgi izveidota!');
    }

    public function show(Consultation $consultation)
    {
        return view('consultations.show', ['consultation' => $consultation]);
    }

    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        return view('consultations.edit', ['consultation' => $consultation]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $consultation = Consultation::findOrFail($id);
        $consultation->update([
            'title' => $request->input('title'),
        ]);

        return redirect()->route('consultations.index')->with('success', 'Konsultācijas datu mainīšana ir veiksmīga');
    }

    public function destroy($id)
    {
        $consultation = Consultation::findOrFail($id);
        $consultation->delete();

        return redirect('/consultations')->with('success', 'Konsultācijas dzēšana ir veiksmīga');
    }
}
