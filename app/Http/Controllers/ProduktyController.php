<?php

namespace App\Http\Controllers;

use App\Models\cassoviacode_interview_22_01_2021\Produkty;
use Illuminate\Http\Request;

class ProduktyController extends Controller
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


        return view('produkty')
//            ->with('tableTotalRowCount', $tableTotalRowCount)
            ;

    }


    /**
     * Return datatables data, ajax request
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatables(Request $request)
    {

        $produkty = Produkty::all();

        $tableData_ar = $produkty->toArray();


        $output = [];
        $output['data'] = $data;

        return response()->json($output);

    }


}
