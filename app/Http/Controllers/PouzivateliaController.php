<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MnoapiProdCluster\Settings\Helpline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PouzivateliaController extends Controller
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
        return view('pouzivatelia');
    }

    /**
     * Pouzivatelia tabulka vratit data,
     * Ajax request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaData(Request $request)
    {

        $pouzivatelia = Pouzivatelia::select('id', 'nazov', 'popis', 'cena')->get();

        foreach($pouzivatelia as $key => $item) {
            $item->radio_btn = "<input type=\"radio\" id=\"tbl_radio_btn_{$item->id}\" class=\"pouzivatelia_table_radio\" name=\"pouzivatelia_table_radio\" value=\"{$item->id}\" >";
            $item->nazov = $item->nazov === null ? '' : $item->nazov;
            $item->popis = $item->popis === null ? '' : $item->popis;
            $item->cena = $item->cena === null ? '' : $item->cena;
            $item->vymazat = "<button type=\"button\" data-id=\"{$item->id}\" data-nazov=\"{$item->nazov}\" class=\"btn btn-danger vymazat_btn\">Vymazat</button>";
        }

//        dd($pouzivatelia);

        $output = [];
        $output['data'] = $pouzivatelia;
        return response()->json($output);

    }


    /**
     * Pouzivatelia stranka, pridat data,
     * Ajax call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaPridatData(Request $request)
    {

        $validation_rules = [
            'nazov' => 'required|max:250',
            'popis' => 'max:5000|',
            'cena' => 'required|numeric',
        ];

        $validation_messages = [
            'required' => ':attribute je potrebné vyplniť',
            'max' => ':attribute musí mať maximálne :max symboly',
            'numeric' => ':attribute musí byť v číselnom formáte',
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $pouzivatelia = new Pouzivatelia();
        $pouzivatelia->nazov = $request->nazov;
        $pouzivatelia->popis = $request->popis;
        $pouzivatelia->cena = $request->cena;

        $pouzivatelia->save();
        $id = $pouzivatelia->id;

        return Response()->json([
            'status' => 'success',
            'id' => $id,
        ], 200);

    }


    /**
     * Pouzivatelia stranka, vratit data pre upravu riadku,
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaUpravaData(Request $request)
    {

        if (!$request->has('id')) {
            exit('not valid request');
        }
        $objednavk = Pouzivatelia::find($request->id);

        return response()->json($objednavk);
    }


    /**
     * Pouzivatelia stranka tabulka upravit riadok,
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaUpravitData(Request $request)
    {

        if (!$request->has('id')) {
            exit('not valid request');
        }

        $validation_rules = [
            'nazov' => 'required|max:250',
            'popis' => 'max:5000|',
            'cena' => 'required|numeric',
        ];

        $validation_messages = [
            'required' => ':attribute je potrebné vyplniť',
            'max' => ':attribute musí mať maximálne :max symboly',
            'numeric' => ':attribute musí byť v číselnom formáte',
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $objednavka = Pouzivatelia::find($request->id);
        $objednavka->nazov = $request->nazov;
        $objednavka->popis = $request->popis;
        $objednavka->cena = $request->cena;

        $objednavka->save();

        return Response()->json([
            'status' => 'success',
        ], 200);


    }


    /**
     * Pouzivatelia stranka tabulka vymazať riadok,
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
        $ee_uk = Pouzivatelia::find($request->id);
        $ee_uk->delete();

        return Response()->json([
            'status' => 'success',
        ], 200);

    }

}
