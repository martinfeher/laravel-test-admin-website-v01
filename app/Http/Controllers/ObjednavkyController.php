<?php

namespace App\Http\Controllers;

use App\Models\cassoviacode_interview_22_01_2021\Objednavky;
use App\Models\cassoviacode_interview_22_01_2021\Produkty;
use App\Models\MnoapiProdCluster\Settings\Helpline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
        $produkty = Produkty::select('id', 'nazov')->get();
        return view('objednavky')
            ->with('produkty', $produkty);
    }

    /**
     * Objednavky tabulka vratit data,
     * Ajax request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaData(Request $request)
    {

        $objednavky = Objednavky::select('id', 'nazov', 'popis', 'produkty')->get();

        foreach($objednavky as $key => $item) {
            $item->radio_btn = "<input type=\"radio\" id=\"tbl_radio_btn_{$item->id}\" class=\"objednavky_table_radio\" name=\"objednavky_table_radio\" value=\"{$item->id}\" >";
            $item->nazov = $item->nazov === null ? '' : $item->nazov;
            $item->popis = $item->popis === null ? '' : $item->popis;
            $item->produkty = $item->produkty === null ? '' : $item->produkty;
            $item->vymazat = "<button type=\"button\" data-id=\"{$item->id}\" data-nazov=\"{$item->nazov}\" class=\"btn-sm btn-danger vymazat_btn\">Vymazať</button>";
        }

//        dd($objednavky);

        $output = [];
        $output['data'] = $objednavky;
        return response()->json($output);

    }


    /**
     * Objednavky stranka, pridat data,
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
            'produkty' => 'required|numeric',
            'image_upload' => 'mimes:jpg, png, doc, docx, pdf',
        ];

        $validation_messages = [
            'required' => ':attribute je potrebné vyplniť',
            'max' => ':attribute musí mať maximálne :max symboly',
            'numeric' => ':attribute musí byť v číselnom formáte',
            'mimes' => ':attribute nahratý súbor musí byť v jednom z týchto formátov jpg, png, doc, docx, pdf ',
        ];

        $validator = Validator::make($request->all(), $validation_rules, $validation_messages);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $objednavky = new Objednavky();
        $objednavky->nazov = $request->nazov;
        $objednavky->popis = $request->popis;
        $objednavky->produkty = $request->produkty;

        if ($request->hasfile('image_upload')) {
            $filenameWithExt = $request->file('image_upload')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image_upload')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('image_upload')->storeAs('public/uploads', $fileNameToStore);
            $objednavky->dokument_path = $path;
        }

        $objednavky->save();
        $id = $objednavky->id;

        return Response()->json([
            'status' => 'success',
            'id' => $id,
        ], 200);

    }


    /**
     * Objednavky stranka, vratit data pre upravu riadku,
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaUpravaData(Request $request)
    {

        if (!$request->has('id')) {
            exit('not valid request');
        }
        $objednavk = Objednavky::find($request->id);

        return response()->json($objednavk);
    }


    /**
     * Objednavky stranka tabulka upravit riadok,
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
            'produkty' => 'required|numeric',
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

        $objednavka = Objednavky::find($request->id);
        $objednavka->nazov = $request->nazov;
        $objednavka->popis = $request->popis;
        $objednavka->produkty = $request->produkty;

        $objednavka->save();

        return Response()->json([
            'status' => 'success',
        ], 200);


    }

    /**
     * Objednavky stranka tabulka vymazať riadok,
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
        $ee_uk = Objednavky::find($request->id);
        $ee_uk->delete();

        return Response()->json([
            'status' => 'success',
        ], 200);

    }

}
