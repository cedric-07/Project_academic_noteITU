<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Config;
use App\Models\Etudiant;
use App\Models\EtudiantSemestre;
use App\Models\Genre;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Promotion;
use App\Models\Semestre;
use Illuminate\Support\Facades\DB;
class TruncateController extends Controller
{
    //
    public function truncateTables()
    {
        DB::beginTransaction();

        try {
            //code...
            Etudiant::truncate();
            EtudiantSemestre::truncate();
            Note::truncate();
            Config::truncate();
            Promotion::truncate();
            DB::commit();

            return redirect(route('import.importpage'))->with('success', 'The tables have been truncated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', 'Error truncating the tables');
        }
    }
}
