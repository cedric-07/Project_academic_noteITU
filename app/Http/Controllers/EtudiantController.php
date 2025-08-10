<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\EtudiantSemestre;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Promotion;
use App\Models\Semestre;

class EtudiantController extends Controller
{
    //
    public function getEtudiant()
    {
        $categories = Categorie::all()->first();
        $etudiants = Etudiant::with('promotion')->first();
        $etudiant = Etudiant::all();
        $promotions = Promotion::all();
        return view('AdminPage.etudiantPage' , compact('etudiant' , 'promotions' , 'categories' ));
    }

    public function search(Request $request)
    {
        $query = Etudiant::query();

        if ($request->filled('nom')) {
            $query->whereRaw('LOWER(nom) LIKE ?', ['%' . strtolower($request->nom) . '%']);
        }

        if ($request->filled('promotion')) {
            $query->where('idpromotion', $request->promotion);
        }

        $etudiants = $query->get();

        if ($etudiants->isEmpty()) {
            return view('AdminPage.etudiantFilterPage', compact('etudiants'))
                   ->with('error', 'No results found.');
        }

        return view('AdminPage.etudiantFilterPage', compact('etudiants'));
    }


    //Admin
    public function getSemester($etudiantsId)
    {
        // Récupérer les moyennes par semestre pour l'étudiant
        $moyennes = Note::getmoyennebysemestrebyetudiant($etudiantsId);

        // Récupérer les semestres disponibles
        $semestres = Semestre::all();

        // Récupérer les informations de l'étudiant (par exemple, utiliser l'ID passé)
        $etudiant = Etudiant::find($etudiantsId);

        // Récupérer les catégories (par exemple, en utilisant un modèle Category)
        $categories = Categorie::all();

        // Passer les données à la vue
        return view('AdminPage.semestrePage', compact('semestres', 'etudiant', 'moyennes', 'categories'));
    }

    public function getEtudiantBysemestre($semestreId)
    {
        $moyennes = Note::getmoyenneetudiantBysemestre($semestreId);
        $moyennes = $moyennes->sortBy('rang');
        $etudiants = Etudiant::all();

        return view('AdminPage.etudiantBySemestrePage' , compact('moyennes' , 'etudiants'));
    }

    //Etudiant
    public function getSemestre($etudiantsId)
    {
        $moyennes = Note::getmoyennebysemestrebyetudiant($etudiantsId);

        // Récupérer les semestres disponibles
        $semestres = Semestre::all();

        // Récupérer les informations de l'étudiant (par exemple, utiliser l'ID passé)
        $etudiant = Etudiant::find($etudiantsId);

        // Récupérer les catégories (par exemple, en utilisant un modèle Category)
        $categories = Categorie::all();
        return view('Pages.resultsemestrePage' , compact('categories' , 'etudiant' , 'moyennes' , 'semestres' ));
    }

    public function getnbretudiantAjourLicence()
    {
        $nbrajour = Semestre::isNotAdmis();
        $nbradmis = Semestre::isAdmis();
        $nbretudiant = Semestre::NombreEtudiant();

        $status = Semestre::getEtudiantStatus();



        $etudiants = Etudiant::all();

        return view('AdminPage.dashboardPage' , compact('nbrajour' , 'nbradmis' , 'nbretudiant' , 'status' , 'etudiants' ));
    }

    // public function getnbretudiantAjourLicence()
    // {
    //     $nbrajour = Semestre::isNotAdmis();
    //     $nbradmis = Semestre::isAdmis();
    //     $nbretudiant = Semestre::NombreEtudiant();

    //     $status = Semestre::getEtudiantStatus();

    //     // Ajout des moyennes pour chaque étudiant
    //     foreach ($status as &$stat) {
    //         $stat['moyenne'] = $stat['etudiant']->notes()->getMoyenne();
    //     }

    //     $etudiants = Etudiant::all();

    //     return view('AdminPage.dashboardPage', compact('nbrajour', 'nbradmis', 'nbretudiant', 'status', 'etudiants'));
    // }



    public function getcategoriewithetudiant($categorieId , $etudiantsId)
    {
        //get all categories and group by nom
        $categorie = Categorie::all()->groupBy('nom');
        //$categorie = Categorie::All();
        $etudiant = Etudiant::where('idetudiant' , $etudiantsId)->first();

        return view('AdminPage.categoriePage' , compact('categorie' , 'etudiant'));
    }

    // public function getnotePerSemestre($semestreId , $etudiantsId)
    // {
    //     $notes = Note::getnotes($etudiantsId, $semestreId);
    //     $ajournes = Note::getajournes($etudiantsId, $semestreId);
    //     $moyenneGenerale = Note::getmoyennebysemestre();
    //     return view('Pages.resultsemestrePage' , compact('notes' , 'ajournes' , 'moyenneGenerale'));
    // }

    public function getMatiereAjournee($semestreId, $etudiantId)
    {
        $data = Note::getMatiereAjournee($semestreId, $etudiantId);
        $semester = Semestre::find($semestreId);
        return view('Pages.MatiereAjourPage', [
            'matieresAjournees' => $data['matieres'],
            'montantTotal' => $data['montantTotal'],
            'semestre' => $semester,
        ]);

    }

}
