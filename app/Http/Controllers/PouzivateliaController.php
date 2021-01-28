<?php

namespace App\Http\Controllers;

use App\Models\User;
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
     * User tabulka vratit data,
     * Ajax request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tabulkaData(Request $request)
    {

        $users = User::select('id', 'meno', 'email', 'created_at')->where('rola', 'user')->get();

        foreach($users as $key => $item) {
            $item->meno = $item->meno === null ? '' : $item->meno;
            $item->email = $item->email === null ? '' : $item->email;
            $item->vytvoreny = $item->Vytvoreny;
            $item->vymazat = "<button type=\"button\" data-id=\"{$item->id}\" data-email=\"{$item->email}\" class=\"btn-sm btn-danger vymazat_btn\">Vymazať</button>";
        }

        $output = [];
        $output['data'] = $users;
        return response()->json($output);

    }

    /**
     * User stranka tabulka vymazať riadok,
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

        $user = User::find($request->id);
        $user->delete();

        return Response()->json([
            'status' => 'success',
        ], 200);

    }

}
