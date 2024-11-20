<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use app\Models\Consultation\HomeController;


class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consultation = Consultation::all();
        return view('consultations.index', ['consultations'=> $consultation]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('consultations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255', 
        ]);

        Consultation::create([
            'title' => $request->title, 
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $consultation = Consultation::findOrFail($id); // Atrod konkrētu ierakstu
        return view('consultations.edit', compact('consultation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
    
        $consultation = Consultation::findOrFail($id);
        $consultation->update([
            'title' => $request->title,
        ]);

        return redirect()->route('consultations.index')->with('success', 'Consultation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $consultation = Consultation::findOrFail($id);
    $consultation->delete();

    return redirect()->route('consultations.index')->with('success', 'Consultation deleted successfully.');

    }
}
