<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AssureController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\GestionnaireController;
use Illuminate\Support\Facades\Route;

// Routes pour le changement de mot de passe obligatoire
Route::middleware(['auth'])->group(function () {
    Route::get('/password/change', [App\Http\Controllers\PasswordController::class, 'showChangeForm'])->name('password.change');
    Route::post('/password/update', [App\Http\Controllers\PasswordController::class, 'update'])->name('password.update');
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Routes pour les notifications
Route::prefix('notifications')->name('notifications.')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::post('/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::delete('/destroy-all', [App\Http\Controllers\NotificationController::class, 'destroyAll'])->name('destroy-all');
    Route::post('/{id}/mark-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('mark-read');
    Route::delete('/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('destroy');
    Route::get('/unread', [App\Http\Controllers\NotificationController::class, 'getUnread'])->name('unread');
});

// Routes AJAX pour le dashboard
Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {
    Route::get('/stats', [App\Http\Controllers\DashboardController::class, 'getStatsAjax'])->name('stats');
    Route::get('/activity', [App\Http\Controllers\DashboardController::class, 'getActivityAjax'])->name('activity');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes pour les clients (entreprises)
    Route::resource('clients', ClientController::class);
    
    // Routes pour les gestionnaires (admin seulement)
    Route::middleware('role:admin')->group(function () {
        Route::resource('gestionnaires', GestionnaireController::class);
        Route::patch('gestionnaires/{gestionnaire}/statut', [GestionnaireController::class, 'updateStatut'])->name('gestionnaires.update-statut');
        Route::get('gestionnaires/stats', [GestionnaireController::class, 'getStats'])->name('gestionnaires.stats');
        Route::get('gestionnaires/export', [GestionnaireController::class, 'export'])->name('gestionnaires.export');
        Route::post('gestionnaires/import', [GestionnaireController::class, 'import'])->name('gestionnaires.import');
        Route::get('gestionnaires/template', [GestionnaireController::class, 'downloadTemplate'])->name('gestionnaires.template');
    });
    
    // Routes pour les assurés
    Route::resource('assures', AssureController::class);
    Route::get('assures/{assure}/export', [AssureController::class, 'export'])->name('assures.export');
    Route::post('assures/{assure}/beneficiaires', [AssureController::class, 'addBeneficiaire'])->name('assures.beneficiaires.add');
    
    // Routes pour les demandes
    Route::resource('demandes', DemandeController::class);
    Route::patch('demandes/{demande}/traiter', [DemandeController::class, 'traiter'])->name('demandes.traiter');
    
    // Routes pour l'import/export
    Route::get('import', [ImportController::class, 'index'])->name('import.index');
    Route::post('import', [ImportController::class, 'store'])->name('import.store');
    Route::get('import/template', [ImportController::class, 'downloadTemplate'])->name('import.template');
});

require __DIR__.'/auth.php';
