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
    public function tabulkaData(Request $request)
    {

        $produkty = Produkty::select('id', 'nazov', 'popis', 'cena')->get();


        foreach($produkty as $key => $item) {
            $item->id = $item->id === null ? '' : $item->id;
            $item->radio_btn = "<input type=\"radio\" id=\"tbl_radio_btn_{$item->id}\" class=\"produkty_table_radio\" name=\"produkty_table_radio\" value=\"{$item->id}\" >";
            $item->nazov = $item->nazov === null ? '' : $item->nazov;
            $item->popis = $item->popis === null ? '' : $item->popis;
            $item->cena = $item->cena === null ? '' : $item->cena;
            $item->vymazat = "<button type=\"button\" class=\"btn btn-danger\">Vymazat</button>";
        }
//        $tableData_ar = $produkty->toArray();

        $output = [];
        $output['data'] = $produkty;

        return response()->json($output);

    }


}
