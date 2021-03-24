<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            $user->last_ip = $request->ip();
            $user->save();
        }

        return view('dashboard')->with("user", $user);
    }
}
