<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        return view('dashboard.professor');
    }
}
