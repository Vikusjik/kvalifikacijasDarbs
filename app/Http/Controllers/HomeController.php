<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use app\Models\Consultation\ConsultationController;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) { // Pārbauda, vai lietotājs ir autentificējies
            $usertype = Auth::user()->usertype;

            if ($usertype == 'user') {
                return redirect()->route('consultations.index');
            } elseif ($usertype == 'admin') {
                return view ('skolotajs.home');
            }
        } else {
            return redirect('login'); // Nosūta uz autentifikācijas lapu, ja nav ienācis
        }
    }
}
