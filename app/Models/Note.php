<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Note extends Model
{
    use HasFactory;
    protected $table = 'notes';
    protected $primaryKey = 'idnote';
    protected $fillable = ['idetudiant' , 'idmatiere' , 'idsemestre' , 'note' , 'created_at' , 'updated_at'];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class , 'idetudiant');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class , 'idmatiere');
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class , 'idsemestre');
    }

    //function to remove the duplicated note
    public static function removeDuplicates($notes)
    {
        $uniqueNotes = [];
        foreach ($notes as $note) {
            if($note['groupe'] == null){
                $uniqueNotes[] = $note;
            } else if (!isset($uniqueNotes[$note['groupe']]) && $note['groupe'] != null) {
                $uniqueNotes[$note['groupe']] = $note;
            } else {
                if ($note['note'] > $uniqueNotes[$note['groupe']]['note']) {
                    $uniqueNotes[$note['groupe']] = $note;
                }
            }
        }
        return array_values($uniqueNotes);
    }

    //function to remove the duplicated note
    public static function getMaxnoteWithRemoveDuplicatedNote($notes)
    {
          $uniqueNotes = [];
          foreach ($notes as $note) {
              if($note['groupe'] == null){
                  $uniqueNotes[] = $note;
              } else if (!isset($uniqueNotes[$note['groupe']]) && $note['groupe'] != null) {
                  $uniqueNotes[$note['groupe']] = $note;
              } else {
                  if ($note['note'] > $uniqueNotes[$note['groupe']]['note']) {
                      $uniqueNotes[$note['groupe']] = $note;
                  }
              }
          }
          return array_values($uniqueNotes);
    }

    //function to get the note etudiant by semestre
    public static function checkOptionnelle($semestreId, $etudiantsId)
    {
        $notes = ViewNoteMax::where(function ($query) use ($semestreId) {
                    $query->where('idsemestre', $semestreId)
                          ->orWhereNull('idsemestre');
                })
                ->where('idetudiant', $etudiantsId)
                ->get();
        $notes = self::removeDuplicates($notes);

        $avgnote = AvgNote::where(function ($query) use ($semestreId) {
                    $query->where('idsemestre', $semestreId)
                          ->orWhereNull('idsemestre');
                })
                ->where('idetudiant', $etudiantsId)
                ->get();
        $avgnote = self::getMaxnoteWithRemoveDuplicatedNote($avgnote);
        $conf3 = Config::where('code', 'CONF3')->first();

        if ($conf3->valeur == 1)
        {
            return $notes;
        }
        else
        {
            return $notes = $avgnote;
        }

        return $notes;

    }

    //function to calcul the total credits
    public static function getcredits($etudiantsId, $semestreId)
    {
        $notes = Note::checkOptionnelle($semestreId, $etudiantsId);
        $totalCredits = collect($notes)->sum('coefficient');
        return $totalCredits;
    }

    //function to get moyenne etudiants
    public static function getmoyenne($etudiantsId, $semestreId)
    {
        // Obtenir les notes en fonction des paramètres
        $notes = Note::checkOptionnelle($semestreId, $etudiantsId);

        // Récupérer les crédits totaux
        $totalCredits = Note::getcredits($etudiantsId, $semestreId);

        // Vérifier si les notes sont un tableau ou une valeur unique
        if (is_array($notes) || $notes instanceof \Illuminate\Support\Collection) {
            // Calculer la somme des notes pondérées par les coefficients
            $totalnote = collect($notes)->sum(function($note) {
                // Assurer que chaque note est un objet avec les propriétés nécessaires
                if (is_object($note) && isset($note->coefficient) && isset($note->note)) {
                    return $note->coefficient * $note->note;
                }
                return 0; // Retourner 0 si les propriétés n'existent pas
            });

            // Calculer la moyenne
            $moyenne = ($totalCredits == 0) ? 0 : $totalnote / $totalCredits;
        } else {
            // Si les notes sont une valeur unique (moyenne), l'utiliser directement
            $moyenne = $notes;
        }

        // Formater la moyenne à deux décimales
        $moyenne = number_format($moyenne, 2);

        return $moyenne;
    }

    //function to check the note ajournee
    public static function checknote($semestreId, $etudiantsId)
    {
        $ajournee = false;

        // Utilise la méthode checkOptionnelle pour obtenir les notes filtrées
        $notes = self::checkOptionnelle($semestreId, $etudiantsId);

        // Vérifie le nombre de notes inférieures à 10
        $countajour = collect($notes)->where('note', '<', 10)->count();
        $conf1 = Config::where('code', 'CONF1')->first();
        $conf2 = Config::where('code', 'CONF2')->first();

        if ($countajour > $conf2->valeur) {
            $ajournee = true;

        } else {
            $countinf6 = collect($notes)->where('note', '<', $conf1->valeur )->count();

            if ($countinf6 > 0) {
                $ajournee = true;

            } else {

               $moyenne = Note::getmoyenne($etudiantsId, $semestreId);
                    if ($moyenne < 10) {
                        $ajournee = true;
                    }
            }
        }

        return $ajournee;
    }

    //function to get the matiere ajournee
    public static function getMatiereAjournee($semestreId, $etudiantId)
    {
        $notes = Note::checkOptionnelle($semestreId, $etudiantId);
        $ajournee = Note::checknote($semestreId, $etudiantId);
        $moyenne = Note::getmoyenne($etudiantId, $semestreId);
        $matieres = [];
        $montantParMatiere = 25000; // Montant par matière en Ariary

        if($ajournee){
            foreach ($notes as $note) {
                if ($note->note < 10 && $moyenne < 10) {
                    $matieres[] = $note;
                }
            }
        }

        $montantTotal = count($matieres) * $montantParMatiere;

        return [
            'matieres' => $matieres,
            'montantTotal' => $montantTotal
        ];
    }




    //function to get the note etudiant par annee universitaire
    public static function getNotesByCategorie($nomCategorie, $etudiantId)
    {
        //get respective semestre for this $nomCategorie
        $semestre = Categorie::where('nom', $nomCategorie)->get();
        $mentions = [];
        $listNotesPerSemestre = [];

        foreach ($semestre as $s) {
            $listNotesPerSemestre[$s->idsemestre] = Note::checkOptionnelle($s->idsemestre, $etudiantId);
            $mentions[$s->idsemestre] = Note::checknote($s->idsemestre, $etudiantId);


        }

        $moyennesParSemestre = [];
        foreach ($listNotesPerSemestre as $key => $value) {
            $moyennesParSemestre[$key] = self::getmoyenne($etudiantId, $key);
        }
        $listNotesPerSemestre['moyennesParSemestre'] = $moyennesParSemestre;

        $moyennesGenerale = self::getmoyenneGenerale($moyennesParSemestre);

        $listNotesPerSemestre['moyenneGenerale'] = $moyennesGenerale;

        $listNotesPerSemestre['mentions'] = $mentions;




        return $listNotesPerSemestre;
    }

    //function to get moyenne generale
    public static function getmoyenneGenerale($moyennes)
    {
        $totalMoyenne = 0;
        $moyenneGenerale = 0;
        foreach ($moyennes as $moyenne) {
            if ($moyenne > 0) {
                $totalMoyenne += $moyenne;
            }
        }
        if (is_countable($moyennes) && count($moyennes) >= 2) {
            # code...
            $moyenneGenerale = $totalMoyenne / count($moyennes);
        } else {
            $moyenneGenerale = 0;
        }
        return $moyenneGenerale;
    }


    //function get moyenne etudiant per semestre donnee
    public static function getmoyenneetudiantBysemestre($semestreId)
    {
        $etudiants = Etudiant::all();
        $moyenneEtudiant = [];

        foreach ($etudiants as $etudiant) {
            // Récupérer la moyenne pour l'étudiant courant en utilisant la fonction `getmoyenne`
            $moyenne = Note::getmoyenne($etudiant->idetudiant, $semestreId);

            // Insertion ou mise à jour dans la table `moyennesemester`
            DB::table('moyennesemester')->updateOrInsert(
                ['idetudiant' => $etudiant->idetudiant, 'idsemestre' => $semestreId],
                ['moyenne' => $moyenne]
            );

            // Stocker la moyenne dans un tableau associatif pour chaque étudiant
            $moyenneEtudiant[$etudiant->idetudiant] = $moyenne;
        }

        // Récupérer les moyennes avec rang pour les étudiants du semestre
        $moyennesAvecRang = DB::table(DB::raw('(
            SELECT idetudiant, idsemestre, moyenne,
            DENSE_RANK() OVER (ORDER BY moyenne DESC) AS rang
            FROM moyennesemester WHERE idsemestre = ?
        ) AS rang'))
        ->setBindings([$semestreId])
        ->select('idetudiant', 'idsemestre', 'moyenne', 'rang')
        ->orderBy('rang')  // Trier les résultats par rang (ordre croissant)
        ->get();

        // Retourner les moyennes avec rang
        return $moyennesAvecRang;
    }



    //function to get the moyenne for all etudiants in a semestre donnee
    public static function getmoyennebysemestrebyetudiant($etudiantsId)
    {
        $semestres = Semestre::all();
        $moyennes = []; // Initialiser le tableau pour stocker les moyennes

        foreach ($semestres as $semestre) {
            // Calculer la moyenne pour chaque semestre
            $moyenne = self::getmoyenne($etudiantsId, $semestre->idsemestre);

            // Stocker la moyenne dans le tableau si elle n'est pas zéro
            if ($moyenne > 0) {
                $moyennes[$semestre->idsemestre] = $moyenne;
            }
        }

        return $moyennes; // Retourner le tableau des moyennes filtré
    }



    //function get moyenne generale for all etudiants per semestre
    public static function getmoyennebysemestre($semestreId , $etudiantId)
    {
        $moyenneParSemestre = self::getmoyenne($semestreId , $etudiantId);
        $moyenneParSemestre = collect($moyenneParSemestre);
        $totalMoyenne = 0;
        $moyenneGenerale = 0;
        foreach ($moyenneParSemestre as $moyenne) {
            if ($moyenne > 0) {
                $totalMoyenne += $moyenne;
            }
        }

        if (is_countable($moyenneParSemestre) && count($moyenneParSemestre) >= 2) {
            # code...

            $moyenneGenerale = $totalMoyenne / count($moyenneParSemestre);
            return $moyenneGenerale;
        } else {
            return 0;
        }
        return $moyenneGenerale;

    }



}

