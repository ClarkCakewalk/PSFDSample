<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SampleController extends Controller
{
    public function create()
    {
        return view('addSample');
    }

    public function store(Request $request) {
        $validated= $request->validate([
            'sampleId'=>'unique:sample,sampleId'
        ]);
    }
}
