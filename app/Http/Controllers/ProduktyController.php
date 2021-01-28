<?php

namespace App\Http\Controllers;

use App\Models\cassoviacode_interview_22_01_2021\Objednavky;
use App\Models\cassoviacode_interview_22_01_2021\Produkty;
use App\Models\cassoviacode_interview_22_01_2021\ProduktyObjednavkyPivot;
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
            $item->radio_btn = "<input type=\"radio\" id=\"tbl_radio_btn_{$item->id}\" class=\"produkty_table_radio\" name=\"produkty_table_radio\" value=\"{$item->id}\" >";
            $item->nazov = $item->nazov === null ? '' : $item->nazov;
            $item->popis = $item->popis === null ? '' : $item->popis;
            $item->cena = $item->cena === null ? '' : $item->cena;
            $item->vytvorit_objednavku = "<button type=\"button\" data-id=\"{$item->id}\" data-nazov=\"{$item->nazov}\" class=\"btn-sm btn-success vytvorit_objednavku_btn\">Vytvoriť objednávku</button>";
            $item->vymazat = "<button type=\"button\" data-id=\"{$item->id}\" class=\"btn-sm btn-danger vymazat_btn\">Vymazať</button>";
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
    public function pridatZaznam(Request $request)
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
     * Produkty stranka, vratit data pre upravu riadku,
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataPreUpravuZaznamu(Request $request)
    {

        if (!$request->has('id')) {
            exit('not valid request');
        }
        $produkt = Produkty::find($request->id);

        return response()->json($produkt);
    }


    /**
     * Produkty stranka tabulka upravit riadok,
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upravitZaznam(Request $request)
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

        $produkt = Produkty::find($request->id);
        $produkt->nazov = $request->nazov;
        $produkt->popis = $request->popis;
        $produkt->cena = $request->cena;

        $produkt->save();

        return Response()->json([
            'status' => 'success',
        ], 200);

    }


    /**
     * Produkty stranka, vytvorit objednavku
     * Ajax call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vytvoritObjednavku(Request $request)
    {

        $validation_rules = [
            'nazov_objednavky' => 'required|max:250',
            'popis_objednavky' => 'max:5000|',
        ];

        $validation_messages = [
            'required' => ':attribute je potrebné vyplniť',
            'max' => ':attribute musí mať maximálne :max symboly',
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $objednavky = new Objednavky();
        $objednavky->nazov = $request->nazov_objednavky;
        $objednavky->popis = $request->popis_objednavky;

        $objednavky->save();


        $produkty_objednavky_pivot = ProduktyObjednavkyPivot::firstOrCreate([
            'produkty_id' => $request->produkt_id,
            'objednavky_id' => $objednavky->id
        ]);

        return Response()->json([
            'status' => 'success'
        ], 200);

    }


    /**
     * Produkty stranka tabulka vymazať riadok,
     * Ajax call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vymazatData(Request $request)
    {
        if (!$request->has('id')) {
            exit('not valid request');
        }
        $produkt = Produkty::find($request->id);
        $produkt->delete();

        return Response()->json([
            'status' => 'success',
        ], 200);

    }

}
