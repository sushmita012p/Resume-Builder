<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $resumes = auth()->user()->resumes()->latest()->get();
        return view('dashboard', compact('resumes'));
    }
}
