<?php
use App\Http\Controllers\PM\MaterialRequestController;
use App\Http\Controllers\PM\Api\MaterialRequestController as ApiMaterialRequestController;

use App\Http\Controllers\PM\InternalMaterialRequestController;
use App\Http\Controllers\PM\Api\InternalMaterialRequestController as ApiInternalMaterialRequestController;

use App\Http\Controllers\PM\TransferProductController;
use App\Http\Controllers\PM\Api\TransferProductController as ApiTransferProductController;

use App\Http\Controllers\PM\WipRequestController;
use App\Http\Controllers\PM\Api\WipRequestController as ApiWipRequestController;

use App\Http\Controllers\PM\SendCigaretteController;
use App\Http\Controllers\PM\Api\SendCigaretteController as ApiSendCigaretteController;


use App\Http\Controllers\PM\JamController;
use App\Http\Controllers\PM\Api\JamController as ApiJamController;

use App\Http\Controllers\PM\IngredientPreparationController;
use App\Http\Controllers\PM\Api\IngredientPreparationController as ApiIngredientPreparationController;

use App\Http\Controllers\PM\SprinkleTobaccoController;
use App\Http\Controllers\PM\Api\SprinkleTobaccoController as SpisprinkleTobaccoController;

use App\Http\Controllers\PM\ConversTransactionController;
use App\Http\Controllers\PM\Api\ConversTransactionController as ApiConversTransactionController;

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

require base_path('routes/settings/_pm.php');

Route::namespace('Api')->prefix('ajax')->name('ajax.')->group(function () {
    // PMP0032
    Route::prefix('internal-material-requests')->name('internal-material-requests.')->group(function () {
        Route::get('lines', [ApiInternalMaterialRequestController::class, 'lines'])->name('lines');
        Route::get('get-item', [ApiInternalMaterialRequestController::class, 'getItem'])->name('get-item');
        Route::post('store', [ApiInternalMaterialRequestController::class, 'store'])->name('store');
        Route::post('set-status/{requestHeader}', [ApiInternalMaterialRequestController::class, 'setStatus'])->name('set-status');
    });

    Route::prefix('material-requests')->name('material-requests.')->group(function () {
        Route::get('lines', [ApiMaterialRequestController::class, 'lines'])->name('lines');
        Route::get('get-item', [ApiMaterialRequestController::class, 'getItem'])->name('get-item');
        Route::post('store', [ApiMaterialRequestController::class, 'store'])->name('store');
        Route::post('set-status/{requestHeader}', [ApiMaterialRequestController::class, 'setStatus'])->name('set-status');
    });

    Route::prefix('transfer-products')->name('transfer-products.')->group(function () {
        Route::get('get-lines', [ApiTransferProductController::class, 'getLines'])->name('get-lines');
        Route::get('get-item', [ApiTransferProductController::class, 'getItem'])->name('get-item');
        Route::post('store', [ApiTransferProductController::class, 'store'])->name('store');
        Route::post('set-status/{header}', [ApiTransferProductController::class, 'setStatus'])->name('set-status');
        Route::get('get-uom', [ApiTransferProductController::class, 'getUOM'])->name('transfer-products.get-uom');
    });

    Route::prefix('send-cigarettes')->name('send-cigarettes.')->group(function () {
        Route::get('get-lines',             [ApiSendCigaretteController::class, 'getLines'])->name('get-lines');
        Route::get('get-item',              [ApiSendCigaretteController::class, 'getItem'])->name('get-item');
        Route::post('store',                [ApiSendCigaretteController::class, 'store'])->name('store');
        Route::post('set-status/{header}',  [ApiSendCigaretteController::class, 'setStatus'])->name('set-status');
    });

    Route::prefix('wip-requests')->name('wip-requests.')->group(function () {
        Route::get('get-lines', [ApiWipRequestController::class, 'getLines'])->name('get-lines');
        Route::get('get-item', [ApiWipRequestController::class, 'getItem'])->name('get-item');
        Route::post('store', [ApiWipRequestController::class, 'store'])->name('store');
        Route::post('set-status/{header}', [ApiWipRequestController::class, 'setStatus'])->name('set-status');
    });


    Route::prefix('jams')->name('jams.')->group(function () {
        Route::get('get-lines',             [ApiJamController::class, 'getLines'])->name('get-lines');
        Route::get('get-item',              [ApiJamController::class, 'getItem'])->name('get-item');
        Route::post('store',                [ApiJamController::class, 'store'])->name('store');
        Route::post('set-status/{header}',  [ApiJamController::class, 'setStatus'])->name('set-status');
    });

    Route::get('ingredient-preparation-qrcode', [ApiIngredientPreparationController::class, 'index'])->name('ingredient-preparation-qrcode');
    Route::get('ingredient-preparation-detail', [ApiIngredientPreparationController::class, 'getLineDetail'])->name('ingredient-preparation-detail');

    Route::prefix('sprinkle-tobaccos')->name('sprinkle-tobaccos.')->group(function () {
        Route::get('get-lines',             [SpisprinkleTobaccoController::class, 'getLines'])->name('get-lines');
        Route::get('get-item',              [SpisprinkleTobaccoController::class, 'getItem'])->name('get-item');
        Route::post('store',                [SpisprinkleTobaccoController::class, 'store'])->name('store');
        Route::post('cancel',               [SpisprinkleTobaccoController::class, 'cancel'])->name('cancel');
        Route::post('set-status/{header}',  [SpisprinkleTobaccoController::class, 'setStatus'])->name('set-status');
    });

    // PMP0060
    Route::prefix('convers-transactions')->name('convers-transactions.')->group(function () {
        Route::post('/', [ApiConversTransactionController::class, 'store'])->name('store');
    });
});

// PM0032
Route::prefix('internal-material-requests')->name('internal-material-requests.')->group(function () {
    Route::get('/', [InternalMaterialRequestController::class, 'index'])->name('index');
});


// PM0005
Route::prefix('material-requests')->name('material-requests.')->group(function () {
    Route::get('/', [MaterialRequestController::class, 'index'])->name('index');
    // Route::get('/{id}', [MaterialRequestController::class, 'show'])->name('show');
});


// PM0041
Route::prefix('transfer-products')->name('transfer-products.')->group(function () {
    Route::get('/', [TransferProductController::class, 'index'])->name('index');
});

// PM0042
Route::prefix('send-cigarettes')->name('send-cigarettes.')->group(function () {
    Route::get('/', [SendCigaretteController::class, 'index'])->name('index');
});

// PM0044
Route::prefix('wip-requests')->name('wip-requests.')->group(function () {
    Route::get('/', [WipRequestController::class, 'index'])->name('index');
});

// PM0044
Route::prefix('jams')->name('jams.')->group(function () {
    Route::get('/', [JamController::class, 'index'])->name('index');
});

//PMP0028
// Route::prefix('ingredient-preparation')->name('qrcode-return-mtls.')->group(function () {
    // Route::get('ingredient-preparation', [IngredientPreparationController::class, 'index'])->name('ingredient-preparation.index');
//     Route::get('/', [IngredientPreparationController::class, 'index'])->name('index');
// });
Route::get('ingredient-preparation', [IngredientPreparationController::class, 'index'])->name('ingredient-preparation.index');
Route::get('ingredient-preparation/print-pdf', [IngredientPreparationController::class, 'printPdf'])->name('ingredient-preparation.print-pdf');

// Route::resource('ingredient-preparation', IngredientPreparationController::class);
// Route::get('/ingredient-preparation/print-pdf', [IngredientPreparationController::class, 'printPdf'])->name('ingredient-preparation.printPdf');

// PM0055
Route::prefix('sprinkle-tobaccos')->name('sprinkle-tobaccos.')->group(function () {
    Route::get('/', [SprinkleTobaccoController::class, 'index'])->name('index');
});


Route::prefix('appr-formulas')->name('appr-formulas.')->group(function () {
    Route::get('/', function () {
        $user = auth()->user();
        $headers = \App\Models\PM\Settings\Ingredient::where('org_id', $user->organization_id)->orderBy('ingredient_id', 'desc')->paginate(25);
        return view('pm.appr-formulas.index', compact('headers'));
    });

    Route::get('/{id}', function (Request $request, $id) {
        $user         = auth()->user();
        $ingredient   = \App\Models\PM\Settings\Ingredient::where('ingredient_id', $id)->with('organization')->first();
        $items        = \App\Models\PM\PtpmItemNumberV::whereIn('user_item_type', ['Finished good', 'Semi Finished Goods'])->where('organization_id', $ingredient->org_id)->get();
        $machineTypes = \App\Models\PM\Settings\MachineType::where('enabled_flag', 'Y')->orderBy('lookup_code', 'asc')->get();
        $wipSteps     = \App\Models\PM\Settings\OpmRoutingV::where('owner_organization_id', $ingredient->org_id)->orderBy('oprn_class_desc', 'asc')->get();
        $oprns        = $wipSteps->unique('oprn_id')->all();
        $oprnClass    = \App\Models\PM\Settings\FmOprnCls::all();

        return view('pm.appr-formulas.show', compact('ingredient', 'items', 'machineTypes', 'wipSteps', 'oprns', 'oprnClass'));
    })->name('show');
});


// PMP0060
Route::prefix('convers-transactions')->name('convers-transactions.')->group(function () {
    Route::get('/', [ConversTransactionController::class, 'index'])->name('index');
});
