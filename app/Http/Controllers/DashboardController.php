<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications;

        return view('students.dashboard', compact('notifications'));
    }

    public function clearNotifications()
{
    auth()->user()->notifications()->delete();

    return redirect()->route('students.dashboard')->with('success', 'Paziņojumi notīrīti!');
}

}
