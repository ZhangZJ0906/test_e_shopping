<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProFileController extends Controller
{
    //
    public function showProfile() {
        $users = User::findorfail();
        return view('profile');
    }
}
