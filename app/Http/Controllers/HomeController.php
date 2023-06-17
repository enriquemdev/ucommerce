<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
         $is_staff = auth()->user()->is_staff;

         if ($is_staff == 1) {
             return redirect('/admin');
         } else {
             return redirect()->route('dashboard');
         }
    }
}
