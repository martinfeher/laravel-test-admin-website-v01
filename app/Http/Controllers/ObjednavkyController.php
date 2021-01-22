<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ObjednavkyController extends Controller
{
    /**
     * Display Logs Page
     *
     * @param Request $request
     * @return mixed
     *
     */
    public function index(Request $request)
    {


        return view('objednavky')
//            ->with('tableTotalRowCount', $tableTotalRowCount)
            ;

    }
}
