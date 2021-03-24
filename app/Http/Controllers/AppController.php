<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function verifyPublicKey(Request $request) {
        $request->validate([
            'public_key' => 'required|string'
        ]);

        if (User::where('public_key', $request->get('public_key'))->first() == null) {
            return response(false);
        } else {
            return response(true);
        }
    }
}
