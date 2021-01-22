<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserManagementController extends Controller
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


        return view('user-management')
//            ->with('tableTotalRowCount', $tableTotalRowCount)
            ;

    }


}
