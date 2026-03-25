<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Display the wilayah dependent dropdown demo.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.wilayah.ajax');
    }

    /**
     * Display the axios-based wilayah dependent dropdown demo.
     *
     * @return \Illuminate\View\View
     */
    public function axios()
    {
        return view('admin.wilayah.axios');
    }
}
