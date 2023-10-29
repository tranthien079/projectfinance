<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookbankController extends Controller
{
    public function index() {
        $asdasd = '1asdas';
        return view('bookbank.index',compact('asdasd'));
    }
}
