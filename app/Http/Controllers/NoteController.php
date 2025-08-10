<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Etudiant;
use App\Models\EtudiantSemestre;
use App\Models\ExportCSV;
use App\Models\Matiere;
use App\Models\Promotion;
use App\Models\Semestre;
use App\Models\ViewNoteMax;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NoteController extends Controller
{
    //
    public function index()
    {
        $matieres = Matiere::all();
        //get the idetudiant from the table etudiants using pluck
        $promotions = Promotion::all();
        return view('AdminPage.insertnotepage' , compact('matieres',  'promotions'));
    }


    public function confirmation(Request $request)
    {
        // Validation des données de la requête
        $validator = Validator::make($request->all(), [
            'note' => 'required|numeric|min:0|max:20', // Changement de 'min' et 'max' pour 'numeric'
            'matiereId' => 'required',
            'promotionId' => 'required',
        ],[
            'note.required' => 'Please enter your note.',
            'note.numeric' => 'Note must be a number.', // Changement de message pour type de données
            'note.min' => 'Please enter a note between 0 and 20.',
            'note.max' => 'Please enter a note between 0 and 20.',
            'matiereId.required' => 'Please enter your matiere.',
            'promotionId.required' => 'Please enter your etudiant.',

        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Récupération des données de la requête

        $promotion = $request->input('promotionId');
        $matieren = $request->input('matiereId');
        $note = $request->input('note');


        // Vérification et récupération de l'étudiant
        $promotionRecord = Promotion::where('idpromotion', $promotion)->first();
        if (!$promotionRecord) {
            return back()->withErrors([
                'promotion' => 'The credentials you entered did not match our records. Please double-check and try again.',
            ])->withInput();
        }

        // Vérification et récupération de la matière
        $matiereRecord = Matiere::where('idmatiere', $matieren)->first();
        if (!$matiereRecord) {
            return back()->withErrors([
                'matiere' => 'The credentials you entered did not match our records. Please double-check and try again.',
            ])->withInput();
        }

        // Vérification du semestre

        // Vérification de la note
        $note = $request->input('note');
        if ($note < 0 || $note > 20) {
            return back()->withErrors([
                'note' => 'The note must be between 0 and 20.',
            ])->withInput();
        }


        // Récupération des informations pour la vue
        $promotionId = $promotionRecord->idpromotion;
        $promotionNom = $promotionRecord->nom;
        $matiereId = $matiereRecord->idmatiere;
        $matiereNom = $matiereRecord->reference;
        // Affichage de la vue avec les données
        return view('AdminPage.confirmationPage', compact('promotionId', 'promotionNom', 'matiereId', 'matiereNom', 'note'));
    }


    public function addnote(Request $request)
    {

        $etudiants = Etudiant::where('idpromotion', $request->input('promotionId'))->get();
        foreach ($etudiants as $etudiant) {
            $note = new Note();
            $note->idetudiant = $etudiant->idetudiant;
            $note->idmatiere = $request->input('matiereId');
            $note->note = $request->input('note');
            $note->save();
        }

      //show the error message
      if ($note) {
        return redirect()->route('note.confirmation');
    } else {
        return back()->withErrors([
            'error' => 'An error occurred while saving the note. Please try again later.',
        ])->withInput();
    }

        return redirect()->route('note.confirmation');
        // return $note;
    }


    public  function getnote($semestreId, $etudiantsId)
    {

        $ajournee=Note::checknote($semestreId, $etudiantsId);

        $moyenneformat = Note::getmoyenne($etudiantsId , $semestreId);

        $totalCredits = Note::getcredits($etudiantsId , $semestreId);

        $semestre = Semestre::where('idsemestre', $semestreId)->first();
        $etudiant = Etudiant::where('idetudiant', $etudiantsId)->first();
        $etudiantsemestre = EtudiantSemestre::where('idsemestre', $semestreId)->where('idetudiant', $etudiantsId)->first();

        $notes = Note::checkOptionnelle($semestreId, $etudiantsId);

        // Passer les notes, moyenne, crédits, et mention à la vue
        return view('AdminPage.listnotePage', compact('notes', 'ajournee',  'moyenneformat', 'totalCredits', 'etudiant' , 'semestre' , 'etudiantsemestre'));
    }

    public function getNoteByCateg($nomCategorie, $etudiantId)
    {
        $notes = Note::getNotesByCategorie($nomCategorie, $etudiantId);
        $etudiant = Etudiant::where('idetudiant', $etudiantId)->first();
        $semestres = Categorie::where('nom', $nomCategorie)->get();
        $totalCredits = Note::getcredits($etudiantId, $semestres->first()->idsemestre);
        $categorie = Categorie::where('nom', $nomCategorie)->first();




        //dd($notesPerSemestre);
        return view('AdminPage.notePerCategorie', compact('notes', 'categorie' ,  'etudiant', 'semestres' , 'totalCredits'));
    }



    //CHECK NOTE EXECO
    // public function getnote($semestreId, $etudiantsId)
    // {
    //     $ajournee = Note::checknote($semestreId, $etudiantsId);
    //     $moyenne = Note::getmoyenne($etudiantsId , $semestreId);
    //     $totalCredits = Note::getcredits($etudiantsId , $semestreId);

    //     // Récupérer les notes pour l'étudiant et le semestre spécifiés
    //     $notes = ViewNoteMax::where(function ($query) use ($semestreId) {
    //         $query->where('idsemestre', $semestreId)
    //               ->orWhereNull('idsemestre');
    //     })
    //     ->where('idetudiant', $etudiantsId)
    //     ->get();

    //     // Compter les occurrences de chaque note
    //     $noteCounts = $notes->groupBy('note')->map->count();

    //     // Créer un tableau pour stocker les couleurs des notes
    //     $noteColors = [];
    //     $colorClasses = ['result-execo', 'result-passable', 'result-assez-bien', 'result-bien', 'result-tres-bien'];
    //     $colorIndex = 0;

    //     foreach ($noteCounts as $noteValue => $count) {
    //         if ($count > 1) { // Appliquer une couleur uniquement si la note est répétée
    //             $noteColors[$noteValue] = $colorClasses[$colorIndex % count($colorClasses)];
    //             $colorIndex++;
    //         }
    //     }

    //     $semestre = Semestre::where('idsemestre', $semestreId)->first();
    //     $etudiant = Etudiant::where('idetudiant', $etudiantsId)->first();
    //     $etudiantsemestre = EtudiantSemestre::where('idsemestre', $semestreId)->where('idetudiant', $etudiantsId)->first();

    //     // Passer les notes, moyenne, crédits, mention et couleurs à la vue
    //     return view('AdminPage.listnotePage', compact('notes', 'ajournee', 'moyenne', 'totalCredits', 'etudiant', 'semestre', 'etudiantsemestre', 'noteColors'));
    // }


    public function exportCategoriePDF($nomCategorie, $etudiantId)
    {
        $notes = Note::getNotesByCategorie($nomCategorie, $etudiantId);
        $categorie = Categorie::where('nom' , $nomCategorie)->first();
        $etudiant = Etudiant::where('idetudiant', $etudiantId)->first();
        $semestres = Categorie::where('nom', $nomCategorie)->get();
        $totalCredits = Note::getcredits($etudiantId, $semestres->first()->idsemestre);

        $html = view('AdminPage.exportPDFPage', compact('notes', 'categorie' , 'etudiant', 'semestres', 'totalCredits'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'paysage');
        $dompdf->render();
        $filename = 'notesPerCategorie.pdf';

        return $dompdf->stream($filename);
    }




    // public function showMatieresBySemestre($semestreId)
    // {
    //     $matieres = Matiere::getMatieresBySemestre($semestreId);
    //     dd($matieres);
    //     return view('AdminPage.listnotePage', compact('matieres'));
    // }

    public function exportPDF($semestreId , $etudiantsId)
    {

        $ajournee = Note::checknote($semestreId, $etudiantsId);
        $moyenne = Note::getmoyenne($etudiantsId, $semestreId);
        $moyenne = floor($moyenne * 100) / 100;
        $totalCredits = Note::getcredits($etudiantsId, $semestreId);
        $notes = ViewNoteMax::where(function ($query) use ($semestreId) {
            $query->where('idsemestre', $semestreId)
                  ->orWhereNull('idsemestre');
        })
        ->where('idetudiant', $etudiantsId)
        ->get();

        $semestre = Semestre::where('idsemestre', $semestreId)->first();
        $etudiant = Etudiant::where('idetudiant', $etudiantsId)->first();
        $etudiantsemestre = EtudiantSemestre::where('idsemestre', $semestreId)->where('idetudiant', $etudiantsId)->first();

        // Render the HTML view into a variable
        $html = view('Pages.exportPDFPage', compact('notes', 'ajournee', 'moyenne', 'totalCredits', 'etudiant', 'semestre', 'etudiantsemestre'))->render();

        // Initialize Dompdf with options
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $filename = 'notes.pdf';
        return $dompdf->stream($filename);
    }



    public function exportCategorieCsv($nomCategorie, $etudiantId)
    {
        try {
            // Récupérer la catégorie, l'étudiant
            $categorie = Categorie::where('nom', $nomCategorie)->firstOrFail();
            $etudiant = Etudiant::findOrFail($etudiantId);

            // Récupérer tous les semestres associés à la catégorie
            $semestres = Categorie::where('nom', $nomCategorie)->get();

            // Récupération des notes par catégorie
            $notes = Note::getNotesByCategorie($nomCategorie, $etudiantId);

            // Nom du fichier CSV
            $filename = 'notes_' . $nomCategorie . '_' . $etudiant->nom . '.csv';

            // Création de la réponse CSV
            $response = new StreamedResponse(function() use ($notes, $categorie, $etudiant, $semestres) {
                $handle = fopen('php://output', 'w');

                // En-tête des colonnes
                fputcsv($handle, ['Référence', 'Libellé', 'Coefficient', 'Note', 'Catégorie', 'Étudiant', 'Semestre']);

                // Parcourir les semestres
                foreach ($semestres as $semestre) {
                    // Calcul des crédits pour le semestre courant

                    // Parcourir les notes pour chaque semestre
                        foreach ($notes[$semestre->idsemestre] as $note) {
                            // Assurez-vous que les propriétés sont bien définies
                            fputcsv($handle, [
                                $note->reference ?? 'N/A',
                                $note->matiere ?? 'N/A',
                                $note->coefficient ?? 'N/A',
                                $note->note ?? 'N/A',
                                $categorie->nom ?? 'N/A',
                                $etudiant->nom . ' ' . $etudiant->prenom ?? 'N/A',
                                'S'.$semestre->idsemestre ?? 'N/A',
                            ]);
                        }

                }

                fclose($handle);
            });

            // Définir les en-têtes HTTP pour le fichier CSV
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
            $response->headers->set('Expires', '0');

            return $response;

        } catch (\Exception $e) {
            // Retourner un message d'erreur détaillé
            return response()->json(['error' => 'Une erreur est survenue : ' . $e->getMessage()], 500);
        }
    }


    public function exportcsv($semestreId , $etudiantsId)
    {
        $ajournee = Note::checknote($semestreId, $etudiantsId);
        $moyenne = Note::getmoyenne($etudiantsId, $semestreId);
        $totalCredits = Note::getcredits($etudiantsId, $semestreId);
        $notes = Note::checkOptionnelle($semestreId, $etudiantsId);


        $semestre = Semestre::where('idsemestre', $semestreId)->first();
        $etudiant = Etudiant::where('idetudiant', $etudiantsId)->first();
        $etudiantsemestre = EtudiantSemestre::where('idsemestre', $semestreId)->where('idetudiant', $etudiantsId)->first();
        $categorie = Categorie::where('idsemestre', $semestreId)->first();
        $filename = 'notes_' . $etudiant->nom . '_' . $semestre->nom . '.csv';

        $response = new StreamedResponse(function() use ($notes, $moyenne, $totalCredits, $ajournee, $semestre, $etudiant, $categorie ,$etudiantsemestre) {
            $handle = fopen('php://output', 'w');

            // En-tête des colonnes
            fputcsv($handle, ['Référence', 'Libellé', 'Coefficient', 'Note', 'Catégorie', 'Étudiant', 'Semestre']);
            foreach ($notes as $note) {
                fputcsv($handle, [
                    $note->reference ?? 'N/A',
                    $note->matiere ?? 'N/A',
                    $note->coefficient ?? 'N/A',
                    $note->note ?? 'N/A',
                    $categorie->nom ?? 'N/A',
                    $etudiant->nom . ' ' . $etudiant->prenom ?? 'N/A',
                    $note->semestre ?? 'N/A',
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"$filename\"");
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0');
        $response->headers->set('Expires', '0');

        return $response;

    }

    public function getmoyenneByetudiantBysemestre($semestre)
    {
        $moyenne = Note::getmoyenneByetudiantBysemestre();
        return view('AdminPage.moyennePage', compact('moyenne'));
    }

}
