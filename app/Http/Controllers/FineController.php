<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;

class FineController extends Controller
{
    public function index()
    {
        $fines = auth()->user()->fines()->with('loan')->latest()->get();

        return view('fine.index', compact('fines'));
    }
}
