<?php

namespace App\Http\Controllers;

use App\Models\cassoviacode_interview_22_01_2021\Objednavky;
use App\Models\cassoviacode_interview_22_01_2021\Produkty;
use App\Models\cassoviacode_interview_22_01_2021\ProduktyObjednavkyPivot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


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

        if (Auth::user()->jeAdministrator()) {
            $objednavky = Objednavky::select('id', 'nazov', 'popis', 'user_id', 'dokument_name')->get();
        } else {
            $objednavky = Objednavky::select('id', 'nazov', 'popis', 'dokument_name')
                ->where('user_id', Auth::user()->id)
                ->get();
        }

        $objednavky = $objednavky->load('produkty');

        foreach($objednavky as $key => $item) {

            $item->radio_btn = "<input type=\"radio\" id=\"tbl_radio_btn_{$item->id}\" class=\"objednavky_table_radio\" name=\"objednavky_table_radio\" value=\"{$item->id}\" >";
            $item->nazov = $item->nazov === null ? '' : $item->nazov;
            $item->popis = $item->popis === null ? '' : $item->popis;
            $item->pridane_produkty = $item->produkty()->pluck('produkty_id')->implode(',');
            $item->dokument_name = $item->dokument_name === null ? '' : $item->dokument_name;
            $item->vymazat = "<button type=\"button\" data-id=\"{$item->id}\" data-nazov=\"{$item->nazov}\" class=\"btn-sm btn-danger vymazat_btn\">Vymazať</button>";
        }

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
    public function pridatZaznam(Request $request)
    {

        $validation_rules = [
            'nazov' => 'required|max:250',
            'popis' => 'max:5000|',
            'dokument_upload' => 'mimes:jpg, png, doc, docx, pdf',
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

        $objednavky = new Objednavky;
        $objednavky->nazov = $request->nazov;
        $objednavky->popis = $request->popis;

        $dokument_name = '';
        if ($request->hasfile('dokument_upload')) {
            $filenameWithExt = $request->file('dokument_upload')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('dokument_upload')->getClientOriginalExtension();
            $dokument_name = $filename . '_' . time() . '.' . $extension;
            $dokument_path = $request->file('dokument_upload')->storeAs('public/uploads', $dokument_name);
            $objednavky->dokument_name = $dokument_name;
            $objednavky->dokument_path = $dokument_path;
        }

        $objednavky->save();
        $id = $objednavky->id;


        $produkty_objednavky_pivot = ProduktyObjednavkyPivot::firstOrCreate([
            'produkty_id' => $request->produkty,
            'objednavky_id' => $id
        ]);

        return Response()->json([
            'status' => 'success',
            'id' => $id,
            'dokument_name' => $dokument_name,
        ], 200);

    }


    /**
     * Objednavky stranka, vratit data pre upravu zaznamu
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataPreUpravuZaznamu(Request $request)
    {

        if (!$request->has('id')) {
            exit('not valid request');
        }

        $objednavka = Objednavky::find($request->id);

        $objednavka = $objednavka->load('produkty');
        $objednavka->pridane_produkty = $objednavka->produkty()->pluck('produkty_id')->implode(',');

        return response()->json($objednavka);
    }


    /**
     * Objednavky stranka upravit zaznam
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
            'dokument_upload' => 'mimes:jpg, png, doc, docx, pdf',
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

        $objednavka = Objednavky::find($request->id);
        $objednavka->nazov = $request->nazov;
        $objednavka->popis = $request->popis;

        $dokument_name = '';
        if ($request->hasfile('dokument_upload')) {
            $filenameWithExt = $request->file('dokument_upload')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('dokument_upload')->getClientOriginalExtension();
            $dokument_name = $filename . '_' . time() . '.' . $extension;
            $dokument_path = $request->file('dokument_upload')->storeAs('public/uploads', $dokument_name);
            $objednavka->dokument_name = $dokument_name;
            $objednavka->dokument_path = $dokument_path;
        }

        $objednavka->save();

        $produkty_objednavky_pivot = ProduktyObjednavkyPivot::firstOrCreate([
                'produkty_id' => $request->produkty,
                'objednavky_id' => $request->id
            ]);


        return Response()->json([
            'status' => 'success',
        ], 200);


    }

    /**
     * Objednavky stranka tabulka vymazať zaznam
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
        $objednavka = Objednavky::find($request->id);
        $objednavka->delete();

        return Response()->json([
            'status' => 'success',
        ], 200);

    }

}
