<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;
    protected $table = 'semestres';
    protected $primaryKey = 'idsemestre';
    protected $fillable = ['nom' , 'created_at' , 'updated_at'];

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public static function  getsemestre()
    {
        $categories = Categorie::with('semestre')->get();

        return $categories;
    }
    public static function calculerCredit($idSemestre)
    {
        $matieres = Matiere::where('idsemestre', $idSemestre)
            ->with('matieroption')
            ->get();

        $groupedMatieres = $matieres->groupBy(function($matiere) {
            return optional($matiere->matieroption)->groupe ?: $matiere->reference;
        });
        $credit = 0;
        foreach ($groupedMatieres as $group) {
            if($group->count() > 0) {
                $credit += $group->first()->coefficient;
            }else{
                $credit += $group->sum('coefficient');
            }
        }

        return $credit;
    }

    //function to count the number students Admitted
    public static function isAdmis()
    {
        $etudiants = Etudiant::all();
        $semestres = Semestre::all();

        $isa = 0;

        foreach ($etudiants as $etudiant) {
            foreach ($semestres as $semestre) {
                $checkajour = Note::checknote($semestre->idsemestre, $etudiant->idetudiant);

                if ($checkajour) {
                    if ($checkajour == true) {
                        # code...
                        break;
                    }
                }
            }
            if (!$checkajour) {
                # code...
                $isa++;
            }
            // dd($ajourne);
        }
        return $isa;
    }

    //function to count the number students Not Admitted
    public static function isNotAdmis()
    {
        $etudiants = Etudiant::all();
        $totaletudiant = $etudiants->count();

        $totalAdmis = self::isAdmis();

        $nbrajour = $totaletudiant - $totalAdmis;

        return $nbrajour;
    }

    public static function NombreEtudiant()
    {
        $etudiants = Etudiant::all();
        $totaletudiant = $etudiants->count();
        return $totaletudiant;
    }

    // public static function getEtudiantStatus()
    // {
    //     $etudiants = Etudiant::all(); // Récupère tous les étudiants
    //     $semestres = Semestre::all(); // Récupère tous les semestres
    //     $etudiantStatus = []; // Tableau pour stocker les étudiants avec leur statut
    //     $isa = 0; // Compteur pour les étudiants admis


    //     foreach ($etudiants as $etudiant) {

    //         foreach ($semestres as $semestre) {
    //             $checkajour = Note::checknote($semestre->idsemestre, $etudiant->idetudiant);

    //             if ($checkajour == true) {
    //                 # code...
    //                 break;
    //             }

    //         }

    //         // Ajouter l'étudiant à la liste avec son statut
    //         if ($checkajour) {
    //             $etudiantStatus[] = ['etudiant' => $etudiant, 'statut' => 'aj'];
    //             $isa++; // Incrémente le compteur des étudiants admis
    //         } else {
    //             $etudiantStatus[] = ['etudiant' => $etudiant, 'statut' => 'admis'];
    //         }
    //     }

    //     return $etudiantStatus;
    // }

    public static function getEtudiantStatus()
    {
        $etudiants = Etudiant::all(); // Récupère tous les étudiants
        $semestres = Semestre::all(); // Récupère tous les semestres
        $etudiantStatus = []; // Tableau pour stocker les étudiants avec leur statut et moyenne
        $isa = 0; // Compteur pour les étudiants admis

        foreach ($etudiants as $etudiant) {
            $checkajour = false;
            $moyenneSemestre = [];

            foreach ($semestres as $semestre) {
                $checkajour = Note::checknote($semestre->idsemestre, $etudiant->idetudiant);

                if ($checkajour) {
                    // Calculer la moyenne pour ce semestre
                    $moyenne = Note::getmoyenne($etudiant->idetudiant, $semestre->idsemestre);
                    $moyenneSemestre[] = ['semestre' => $semestre->nom, 'moyenne' => $moyenne];
                }

                // Si on trouve une note à jour, on peut arrêter la boucle
                if ($checkajour) {
                    break;
                }
            }

            // Ajouter l'étudiant à la liste avec son statut et ses moyennes
            if ($checkajour) {
                $etudiantStatus[] = [
                    'etudiant' => $etudiant,
                    'statut' => 'aj',
                    'moyennes' => $moyenneSemestre
                ];
                $isa++; // Incrémente le compteur des étudiants admis
            } else {
                $etudiantStatus[] = [
                    'etudiant' => $etudiant,
                    'statut' => 'admis',
                    'moyennes' => $moyenneSemestre
                ];
            }
        }

        return $etudiantStatus;
    }

}
