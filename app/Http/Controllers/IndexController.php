<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    

    public function index () {


        $agencies = Agency::all();


        return view('PAGES/index', compact('agencies'));
    }
}
