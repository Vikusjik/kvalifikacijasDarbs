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
                // Novirzīšana uz lietotāja dashboard
                return redirect()->route('students.dashboard'); // Uz dashboard maršrutu
            } elseif ($usertype == 'admin') {
                // Novirzīšana uz admin lapu
                return view('skolotajs.home'); // Admin lapas skats
            }
        } else {
            return redirect('login'); // Ja lietotājs nav pieteicies, tad nosūta uz login
        }
    }
}
