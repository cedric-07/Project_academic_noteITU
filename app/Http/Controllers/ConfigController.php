<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //
    public function index() : View
    {
        $configs = Config::all();
        return view('AdminPage.configPage' , compact('configs') );
    }

    public function update(Request $request)
    {
        // Validation des données de la requête
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'valeur' => 'required|numeric',
        ],[
            'code.required' => 'Please enter your code.',
            'code.int' => 'Please enter a valid code.',
            'valeur.required' => 'Please enter your valeur.',
            'valeur.numeric' => 'Valeur must be a number.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Récupération des données de la requête
        $code = $request->input('code');
        $valeur = $request->input('valeur');
        $config = Config::where('code', $code)->first();
        $config->valeur = $valeur;
        $config->save();
        return redirect()->route('config.configpage')->with('success', 'Configuration updated successfully.');
    }
}
