<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Etudiant;
use App\Models\EtudiantSemestre;
use App\Models\Genre;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Promotion;
use App\Models\Semestre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    //
    public function create()
    {
        return view('AdminPage.importPage');
    }

    public function importconfig(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('config')) {
                # code...
                $file = $request->file('config');
                $handle = fopen($file->getPathname(), 'r');
                $header = fgetcsv($handle, 1000, ',');
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    # code...
                    Config::firstOrCreate([
                        'code' => $row[0],
                        'config' => $row[1],
                        'valeur' => $row[2],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    DB::commit();
                }
                DB::commit();
                return redirect()->back()->with('success', 'Importation reussi');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error('Error importing file: ' . $th->getMessage());
            return back()->with('error', 'Error importing file :' . $th->getMessage());
        }
    }

    public function importnote(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->hasFile('note')) {
                $file = $request->file('note');
                $handle = fopen($file->getPathname(), 'r');
                $header = fgetcsv($handle, 1000, ',');

                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $promotion = Promotion::where('nom', $row[5])->first();
                    if (!$promotion) {
                        $promotion = Promotion::firstOrCreate([
                            'nom' => $row[5],
                            'datedebut' => now(),
                            'datefin' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }



                    $dtn = Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d');
                    $etudiant = Etudiant::where('numetu', $row[0])->first();
                    if (!$etudiant) {
                        $etudiant = Etudiant::firstOrCreate([
                            'numetu' => $row[0],
                            'nom' => $row[1],
                            'prenom' => $row[2],
                            'genre' => $row[3],
                            'dtn' => $dtn,
                            'idpromotion' => $promotion->idpromotion,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    // Vérifier et créer le semestre si nécessaire
                    $semestre = Semestre::where('nom', $row[7])->first();
                    if ($semestre) {
                        EtudiantSemestre::firstOrCreate([
                            'idetudiant' => $etudiant->idetudiant,
                            'idsemestre' => $semestre->idsemestre,
                            'date' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    // Vérifier la matière avant de créer une note
                    $matiere = Matiere::where('reference', $row[6])->first();
                    $noteString = str_replace(',', '.', $row[8]); // Remplacez la virgule par un point
                    $noteValue = (float) $noteString; // Convertissez la chaîne nettoyée en nombre flottant
                    if ($matiere) {
                        Note::Create([
                            'idetudiant' => $etudiant->idetudiant,
                            'idmatiere' => $matiere->idmatiere,
                            'note' => $noteValue,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        Log::warning('Matiere not found for reference: ' . $row[6]);
                    }
                }

                fclose($handle);
                DB::commit();
                return back()->with('success', 'Successfully imported');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error importing file: ' . $th->getMessage());
            return back()->with('error', 'Error importing file :' . $th->getMessage());
        }
    }

}
