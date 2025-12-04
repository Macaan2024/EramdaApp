<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangayCategoryController extends Controller
{
    public function index () {
        

        return view('PAGES/admin/incident-report-barangay-category');
    }
}
