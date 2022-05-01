<?php

use App\Http\Controllers\ActivitesController;
use App\Http\Controllers\CollecteurController;
use App\Http\Controllers\contribuableController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ZoneController;
use App\Models\zone;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [ActivitesController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');


// Route::get('/dashboard', function () {
//     return view('admin.index');
// })->middleware(['auth'])->name('dashboard');

Route::get('contribuable-page', [contribuableController::class, 'index'])->name('contribuable');
Route::get('add-contribuable', [contribuableController::class, 'add'])->name('add.contribuable');
Route::get('add-taxe-to-contribuable', [contribuableController::class, 'addTaxeToContribuable'])->name('add.taxe.contribuable');
Route::get('edit-contribuable/{contribuable}', [contribuableController::class, 'edit'])->name('edit.contribuable');
Route::put('update-contribuable/{contribuable}', [contribuableController::class, 'update'])->name('update.contribuable');
Route::post('save-contribuable', [contribuableController::class, 'savecontribuable'])->name('save.contribuable');
Route::post('save-taxe-contribuable', [contribuableController::class, 'savetaxetocontribubale'])->name('save.taxe.contribuable');
Route::delete('/delete-contribuable/{contribuable}', [contribuableController::class, "delete"])->name("delete.contribuable");
Route::get('check-contribuable', [contribuableController::class, 'statuscheck'])->name('statuscheck');
Route::get('liste-des-taxes-du-contribuable/5468308367738938766202087664778893003/{contribuable}/5468308367738938766202087664778893003/2/873/99/', [contribuableController::class, 'taxelist'])->name('taxe-list');




Route::get('view-taxes', [TaxesController::class, 'viewtaxes'])->name('view-taxes');
Route::post('pointage-de-la-taxe-du-mois/{contribuable}/taxe/{taxe}', [TaxesController::class, 'pointtaxe'])->name('point-taxe');
Route::get('add-new-taxe', [TaxesController::class, 'index'])->name('create-taxe');
Route::post('add-new-taxes', [TaxesController::class, 'savecontaxes'])->name('save.taxes');
Route::get('edit-taxes/{taxes}', [TaxesController::class, 'edit'])->name('edit.taxes');
Route::put('update-taxes/{taxes}', [TaxesController::class, 'update'])->name('update.taxes');




Route::post('contribuable-filter-result-page', [FilterController::class, 'contribuable'])->name('contribuable-filter-result');
Route::post('filter-result', [FilterController::class, 'taxes'])->name('taxes-filter-result');
Route::get('export-all-contribuable', [FilterController::class, 'allcontribuable'])->name('allcontribuableexport');
Route::get('export-all-collecteur', [FilterController::class, 'allcollecteur'])->name('allcollecteurexport');
Route::get('export-all-taxes', [FilterController::class, 'alltaxes'])->name('alltaxeexport');

Route::get('etat-taxes', [FilterController::class, 'etattaxe'])->name('etat.taxe');
Route::get('etat-contribuables', [FilterController::class, 'etatcontribuable'])->name('etat.contribuable');




Route::get('activites', [ActivitesController::class, 'viewactivite'])->name('view-activites');
Route::get('edit-activites/{activite}', [ActivitesController::class, 'edit'])->name('edit.activite');
Route::get('add-new-activite-page', [ActivitesController::class, 'index'])->name('create-activites');
Route::post('add-new-activite', [ActivitesController::class, 'saveactivites'])->name('save.activites');
Route::put('update-activite/{activite}', [ActivitesController::class, 'update'])->name('update.activite');
Route::delete('/delete-activite/{activite}', [ActivitesController::class, "delete"])->name("delete.activite");






Route::get('view-collecteur', [CollecteurController::class, 'index'])->name('view-collecteur');
Route::get('add-collecteur', [CollecteurController::class, 'add'])->name('add.collecteur');
Route::get('edit-collecteur/{collecteur}', [CollecteurController::class, 'edit'])->name('edit.collecteur');
Route::put('update-collecteur/{collecteur}', [CollecteurController::class, 'update'])->name('update.collecteur');
Route::post('save-collecteur', [CollecteurController::class, 'savecollecteur'])->name('save.collecteur');
Route::delete('/delete-collecteur/{collecteur}', [CollecteurController::class, "delete"])->name("delete.collecteur");




Route::get('view-zone', [ZoneController::class, 'index'])->name('view-zone');
Route::get('add-zone', [ZoneController::class, 'add'])->name('add.zone');
Route::get('edit-zone/{zone}', [ZoneController::class, 'edit'])->name('edit.zone');
Route::put('update-zone/{zone}', [ZoneController::class, 'update'])->name('update.zone');
Route::post('save-zone', [ZoneController::class, 'saveZone'])->name('save.zone');
Route::delete('/delete-zone/{zone}', [ZoneController::class, "delete"])->name("delete.zone");





require __DIR__.'/auth.php';
