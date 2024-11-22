<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index()
    {
        return view('students.dashboard'); // Norāda uz dashboard.blade.php
    }
}
