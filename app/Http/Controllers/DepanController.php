<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepanController extends Controller
{
    public function index(){
        return view("depan/index"); 
    }
    public function pusatinformasi(){
        return view("depan/pusatinformasi");
    }
    public function proyek(){
        return view("depan/proyek");
    }
    public function tentang(){
        return view("depan/tentang");
    }
}
