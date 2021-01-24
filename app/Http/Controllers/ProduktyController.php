<?php

namespace App\Http\Controllers;

use App\Models\cassoviacode_interview_22_01_2021\Produkty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

        return view('produkty');

    }

    /**
     * Produkty tabulka vratit data,
     * Ajax request
     *
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
            $item->vymazat = "<button type=\"button\" data-id=\"{$item->id}\" class=\"btn btn-danger vymazat_btn\">Vymazat</button>";
        }

        $output = [];
        $output['data'] = $produkty;
        return response()->json($output);

    }



    /**
     * Produkty stranka, pridat data,
     * Ajax call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaPridatData(Request $request)
    {

        $validation_rules = [
            'nazov' => 'required|max:2',
            'popis' => 'max:2|',
            'cena' => 'required|digits_between:2,3',
        ];

        $validation_messages = [
            'required' => ':attribute je potrebné vyplniť',
            'max' => ':attribute musí mať maximálne :max symboly',
            'digits_between' => ':attribute musí byť mať minimálne :min a maximálne :max',
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $produkty = new Produkty();
        $produkty->nazov = $request->nazov;
        $produkty->popis = $request->popis;
        $produkty->cena = $request->cena;

        $produkty->save();
        $id = $produkty->id;

        return Response()->json([
            'status' => 'success',
            'id' => $id,
        ], 200);

    }


    /**
     * Produkty stranka tabulka vymazať riadok,
     * Ajax call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaVymazatData(Request $request)
    {
        if (!$request->has('id')) {
            exit('not valid request');
        }
        $ee_uk = Produkty::find($request->id);
        $ee_uk->delete();

        return Response()->json([
            'status' => 'success',
        ], 200);

    }

}
