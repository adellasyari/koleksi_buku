<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimulasiController extends Controller
{
    /**
     * Show the frontend-only DOM simulation view.
     */
    public function dom()
    {
        return view('admin.simulasi.dom');
    }

    /**
     * Show the DataTables simulation view.
     */
    public function datatables()
    {
        return view('admin.simulasi.datatables');
    }

    /**
     * Show the Select / Select2 simulation view.
     */
    public function select()
    {
        return view('admin.simulasi.select');
    }
}
