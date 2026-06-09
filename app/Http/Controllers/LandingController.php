<?php

namespace App\Http\Controllers;

use App\Models\JenisPerilaku;
use App\Models\TingkatKecanduan;

class LandingController extends Controller
{
    public function index()
    {
        $jenisPerilaku = JenisPerilaku::all();
        $tingkatKecanduan = TingkatKecanduan::all();
        
        return view('welcome', compact('jenisPerilaku', 'tingkatKecanduan'));
    }
}