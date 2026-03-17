<?php

use App\Http\Controllers\InscritController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CommencerController;
use App\Http\Controllers\EnvoyerController;
use App\Http\Controllers\ParticipantAuthController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\PhaseFinaleController;
use App\Http\Controllers\TournoisController;
use App\Models\Envoyer;
use App\Models\Inscrit;
use App\Models\Tournois;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/create', function () {
    return view('create');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('efootball');
});


Route::get('/participants', function () {
    return view('participants');
});

Route::get('/tournois', function () {
    return view('tournois');
});
Route::get('/tournois1', function () {
    return view('tournois1');
});

Route::get('/regle', function () {
    return view('regle');
});

Route::get('/dashboard', function () {
    $inscrit = Inscrit::count();
    $tournois = Tournois::count();
    $capture = Envoyer::count();
    return view('dashboard', compact('inscrit', 'tournois', 'capture'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


     Route::get('/inscrit/create',[InscritController::class,'create'])->name('inscrit.create');
     Route::get('/inscrit/index',[InscritController::class,'index'])->name('inscrit.index');
     Route::post('/inscrit/store',[InscritController::class,'store'])->name('inscrit.store');
     Route::get('/inscrit/edit/{inscrit}',[InscritController::class,'edit'])->name('inscrit.edit');
     Route::put('/inscrit/update/{inscrit}', [InscritController::class, 'update'])->name('inscrit.update');
     Route::get('/inscrit/show/{inscrit}',[InscritController::class,'show'])->name('inscrit.show');
     Route::get('/inscrit/destroy/{inscrit}',[InscritController::class,'destroy'])->name('inscrit.destroy');
     Route::post('/inscrit/avatar', [InscritController::class, 'updateAvatar'])->name('inscrit.avatar');

     Route::post('/inscrit/{id}/participer', [InscritController::class, 'participer'])
    ->name('inscrit.participer');
    Route::get('/inscrit/attente', [InscritController::class, 'attente'])
    ->name('inscrit.attente');


    Route::get('/connexion', [LoginController::class, 'showLoginForm'])->name('connexion');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::middleware(['participant'])->group(function () {
    Route::get('/participant', function () {
        $tournois = Tournois::count();
        $user = Auth::guard('participant')->user();
        return view('participant', compact('user', 'tournois'));
    })->name('participant'); // ← CE NOM EST CRUCIAL

    Route::get('/participant/tournois', [TournoisController::class, 'publicIndex'])->name('participant.tournois');
Route::get('/participant/tournois/{tournois}', [TournoisController::class, 'publicShow'])->name('participant.tournois.show');
});
    // Route::get('/participant', [ParticipantController::class, 'index'])->name('participant.index');
    // Route::post('/participant/logout', function () {
    // Auth::guard('participant')->logout();
    // return redirect('/');
    // })->name('participant.logout');

    Route::get('/participant/login', [ParticipantAuthController::class, 'showLoginForm'])->name('participant.login.form');
Route::post('/participant/login', [ParticipantAuthController::class, 'login'])->name('participant.login');
Route::post('/participant/logout', [ParticipantAuthController::class, 'logout'])->name('participant.logout');
Route::get('/participant/{id}', [ParticipantController::class, 'show'])->name('participant.show');


// Tournois routes

Route::get('/tournois/create',[TournoisController::class,'create'])->name('tournois.create');
Route::get('/tournois/index',[TournoisController::class,'index'])->name('tournois.index');
Route::post('/tournois/store',[TournoisController::class,'store'])->name('tournois.store');
Route::get('/tournois/edit/{tournois}',[TournoisController::class,'edit'])->name('tournois.edit');
Route::put('/tournois/update/{tournois}', [TournoisController::class, 'update'])->name('tournois.update');
Route::get('/tournois/show/{tournois}',[TournoisController::class,'show'])->name('tournois.show');
Route::delete('/tournois/destroy/{tournois}', [TournoisController::class, 'destroy'])->name('tournois.destroy');


// Route pour afficher les tournois aux participants





// Route::middleware(['participant'])->group(function () {
//     Route::get('/participant', [ParticipantController::class, 'index'])->name('participant.index');
// });

Route::get('/commencer/{id}', [CommencerController::class, 'create'])->name('commencer.create');
Route::post('/commencer/{id}', [CommencerController::class, 'store'])->name('commencer.store');
Route::get('/commencer/index', [CommencerController::class, 'index'])->name('commencer.index');
Route::post('/commencer/{id}/status', [CommencerController::class, 'updateStatus'])->name('commencer.status');


Route::get('/envoyer/index', [EnvoyerController::class, 'index'])->name('envoyer.index');

// Route pour voir les participants autorisés (admin)
Route::get('/admin/participants', [InscritController::class, 'participantsAutorises'])
    ->name('participant.index')
    ->middleware('auth'); // ou votre middleware admin

Route::middleware(['participant'])->group(function () {
    Route::get('/envoyer/{id}', [EnvoyerController::class, 'create'])->name('envoyer.create');
    Route::post('/envoyer/{id}', [EnvoyerController::class, 'store'])->name('envoyer.store');
});


Route::get('/check-session', function () {
    echo "Guard web (admin): " . (Auth::check() ? Auth::user()->email : 'Non connecté') . "<br>";
    echo "Guard participant: " . (Auth::guard('participant')->check() ? Auth::guard('participant')->user()->email : 'Non connecté') . "<br>";
    echo "Session ID: " . session()->getId() . "<br>";

    // Vérifier les redirections
    echo "<h3>Routes disponibles:</h3>";
    echo "<a href='/dashboard'>Dashboard Admin</a><br>";
    echo "<a href='/participant'>Dashboard Participant</a><br>";
    echo "<a href='/participant/login'>Login Participant</a><br>";
});

// Routes pour le classement
Route::post('/classement/update', [InscritController::class, 'updateClassement'])
    ->name('classement.update')
    ->middleware('auth');

Route::post('/classement/envoyer', [InscritController::class, 'envoyerClassement'])
    ->name('classement.envoyer')
    ->middleware('auth');



    // Routes pour les journées et classements
Route::post('/tournois/generer-journees', [TournoisController::class, 'genererJournees'])
    ->name('tournois.generer-journees')
    ->middleware('auth');

Route::get('/admin/calendrier', [TournoisController::class, 'calendrier'])
    ->name('admin.calendrier')
    ->middleware('auth');

Route::post('/admin/sauvegarder-score', [TournoisController::class, 'sauvegarderScore'])
    ->name('admin.sauvegarder-score')
    ->middleware('auth');


Route::get('/admin/classement', [TournoisController::class, 'classement'])
    ->name('admin.classement')
    ->middleware('auth');

    // 🏆 Page des journées + classement pour le participant
Route::get('/participant/tournois/{id}/journees', [TournoisController::class, 'participantJournees'])
    ->name('participant.journees');

Route::get('/tournois/reset', [TournoisController::class, 'reset'])->name('tournois.reset');
//Route::get('/admin/phasefinale', [TournoisController::class, 'phaseFinale'])->name('admin.phasefinale');

Route::get('/admin/liste-avec-classements', [TournoisController::class, 'listeTournoisAvecClassements'])->name('admin.liste-avec-classements');
Route::get('/admin/liste-avec-calendriers', [TournoisController::class, 'listeTournoisAvecCalendriers'])->name('admin.liste-avec-calendriers');
// Liste des tournois pour la gestion des participants
Route::get('/admin/tournois-participants', [TournoisController::class, 'listeTournoisParticipants'])
     ->name('admin.tournois.participants.liste');

// Participants d'un tournoi spécifique
Route::get('/admin/participants/tournoi/{tournoi}', [TournoisController::class, 'participantsParTournoi'])
     ->name('admin.participants.tournoi');

     Route::patch('/inscrits/{id}/authorize', [InscritController::class, 'authorizeParticipant'])
    ->name('inscrits.authorize');

   Route::post('/inscrits/authorize-direct', [InscritController::class, 'authorizeDirect'])->name('inscrits.authorize-direct');

//Route::get('/phase-finale/{tournoi}', [PhaseFinaleController::class, 'show'])->name('phase-finale.show');
//Route::get('/phase-finale/generate/{tournoi}', [PhaseFinaleController::class, 'generate'])->name('phase-finale.generate');
//Route::post('/phase-finale/validate/{match}', [PhaseFinaleController::class, 'validateMatch'])->name('phase-finale.validate');
//Route::get('/admin/phase-finale', [PhaseFinaleController::class, 'phaseFinale'])->name('admin.phase-finale');





// 🏆 AJOUTEZ ces routes corrigées :
// Route principale pour afficher la phase finale
Route::get('/admin/phase-finale/{tournoi_id?}', [PhaseFinaleController::class, 'show'])
    ->name('admin.phase-finale')
    ->middleware('auth');

// Route pour générer la phase finale
Route::post('/admin/phase-finale/generate/{tournoi_id}', [PhaseFinaleController::class, 'generate'])
    ->name('phase-finale.generate')
    ->middleware('auth');

// Route pour valider un match
Route::post('/admin/phase-finale/validate/{match_id}', [PhaseFinaleController::class, 'validateMatch'])
    ->name('phase-finale.validate')
    ->middleware('auth');

// Route alternative pour accéder à la phase finale
Route::get('/tournoi/{tournoi}/phase-finale', [PhaseFinaleController::class, 'show'])
    ->name('phase-finale.show')
    ->middleware('auth');

    // Route pour la liste des tournois phase finale
Route::get('/admin/phase-finale-liste', [PhaseFinaleController::class, 'listeTournois'])
    ->name('admin.phase-finale-liste')
    ->middleware('auth');

// Route pour la phase finale d'un tournoi spécifique (gardez l'existante)
Route::get('/admin/phase-finale/{tournoi_id?}', [PhaseFinaleController::class, 'show'])
    ->name('admin.phase-finale')
    ->middleware('auth');



require __DIR__.'/auth.php';
