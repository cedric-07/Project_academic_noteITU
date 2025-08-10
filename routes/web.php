<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TruncateController;
use App\Models\Etudiant;

Route::get('register', [RegisteredUserController::class, 'create'])
->name('register');

Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('/admin', [AuthenticatedSessionController::class, 'create'])
->name('login');

Route::get('/', [AuthenticatedSessionController::class, 'createEtudiant'])
->name('login');

Route::post('/addadmin', [AuthenticatedSessionController::class, 'loggedAdmin'])->name('admin.login');

Route::post('/', [AuthenticatedSessionController::class, 'loggedEtudiant'])->name('etudiant.login');



Route::get('/Admin/note/notepage' , [NoteController::class, 'index'])->name('note.notepage');


Route::get('/Admin/note/confirmation' , [NoteController::class, 'confirmation'])->name('note.confirmation');

Route::post('/Admin/notes/add', [NoteController::class, 'addnote'])->name('note.addnote');

Route::get('/etudiants', [EtudiantController::class, 'getEtudiant'])->name('etudiant.getetudiant');

Route::get('/semestres/{etudiantsId}', [EtudiantController::class, 'getSemester'])->name('semestre.getsemestre');

Route::get('/Admin/notepage/{semestreId}/{etudiantsId}', [NoteController::class, 'getnote'])->name('note.getnote');


Route::get('/Etudiant/semestrePage/{etudiantsId}' , [EtudiantController::class, 'getSemestre'])->name('semestre.getsemester');

Route::get('/Etudiant/notepage/{semestreId}/{etudiantsId}' , [NoteController::class, 'getnote'])->name('note.checknote');

Route::get('/Etudiant/filter/etudiant' , [EtudiantController::class, 'search'])->name('etudiant.filter');

Route::get('/Admin/importPage' , [ImportController::class, 'create'])->name('import.importpage');


Route::post('/Admin/importNotes' , [ImportController::class, 'importnote'])->name('import.importnote');


Route::post('/Admin/importConfig' , [ImportController::class, 'importconfig'])->name('import.importconfig');

Route::get('/Admin/truncate' , [TruncateController::class, 'truncateTables'])->name('truncate.truncate');

Route::get('/Admin/NbrAdmisPage' , [EtudiantController::class, 'getnbretudiantAdmisLicence'])->name('admis.getnbretudiantAdmisLicence');

Route::get('/Admin/NbrAjourPage' , [EtudiantController::class, 'getnbretudiantAjourLicence'])->name('ajour.getnbretudiantAjourLicence');

Route::get('/Page/exportPDF/{semestreId}/{etudiantsId}' , [NoteController::class, 'exportPDF'])->name('export.exportPDF');


Route::get('/Page/categoriePage/{categorieId}/{etudiantsId}' , [EtudiantController::class, 'getcategoriewithetudiant'])->name('categorie.getcategoriewithsemestre');

Route::get('/Page/notes/{nomCategorie}/{etudiantsId}' , [NoteController::class, 'getNoteByCateg'])->name('note.categorie');

Route::get('/Pages/ExportCategorieNotes/{nomCategorie}/{etudiantsId}' , [NoteController::class, 'exportCategoriePDF'])->name('export.exportCategoriePDF');

Route::get('/Page/ExportCategorieCSV/{nomCategorie}/{etudiantsId}' , [NoteController::class, 'exportCategorieCsv'])->name('export.exportCSV');

Route::get('/Page/ExportCSVFile/{semestreId}/{etudiantsId}' , [NoteController::class, 'exportcsv'])->name('export.exportcsv');

Route::get('/UpdatePage/Configuration note' , [ConfigController::class, 'index'])->name('config.configpage');

Route::put('/Page/ConfigurationPage' , [ConfigController::class, 'update'])->name('config.update');

Route::get('/EtudiantPage/MatiereAjourPage/{semestreId}/{etudiantsId}' , [EtudiantController::class, 'getMatiereAjournee'])->name('matiere.getmatiereajournee');

Route::get('/EtudiantPage/Etudiant/{semestreId}' , [EtudiantController::class, 'getEtudiantBysemestre'])->name('etudiant.getEtudiantBysemestre');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
