<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homeController extends Controller
{
    //
    public function index(){
        return view('home', [
            'signups' => 12,
            'enrollments' => 8,
            'activeStudents' =>4562
        ]);
    }
}
