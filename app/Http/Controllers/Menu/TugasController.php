<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    public function index() {
        return view('menu.tugas.index');
    }

   public function create() {
        return view('menu.tugas.create');
   }

   public function submitted() {
        return view('menu.tugas.submitted');
   }

   public function history() {
        return view('menu.tugas.history');
   }
}
