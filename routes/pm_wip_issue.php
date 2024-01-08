<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PM\WipIssuesController;
use App\Http\Controllers\PM\Api\WipIssuesApiController;
use App\Models\PM\PtpmMesReviewIssueLines;




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

Route::namespace('Api')->prefix('ajax')->name('ajax.')->group(function () {
    Route::get('get-mes-review-issues', [WipIssuesApiController::class, 'getMesReviewIssuesV'])->name('get-me-review-issues-v');
    Route::get('get-opt-from-blend-no', [WipIssuesApiController::class, 'getOptsFromBlends'])->name('opt-from-blend-no');
    Route::get('get-oprn-by-item', [WipIssuesApiController::class, 'getOprnByItem'])->name('get-oprn-by-item');
    Route::get('get-formulas', [WipIssuesApiController::class, 'getFormula'])->name('get-formulas');
    Route::post('save-data', [WipIssuesApiController::class, 'saveData'])->name('save-data');
    Route::post('update-data', [WipIssuesApiController::class, 'updateData'])->name('update-data');
    Route::get('find-classification', [WipIssuesApiController::class, 'findClassification'])->name('find-classification');
    Route::get('get-headers', [WipIssuesApiController::class, 'getHeaders'])->name('get-headers');
    Route::post('cancel-data', [WipIssuesApiController::class, 'cancelData'])->name('cancel-data');
    Route::get('search-header', [WipIssuesApiController::class, 'searchHeader'])->name('search-header');
    Route::get('find-header/{header_id}', [WipIssuesApiController::class, 'findHeader'])->name('find-header');
    // Route::get('search-header-from-month', [WipIssuesApiController::class, 'searchHeaderFromMonth'])->name('search-header-from-month');

});


Route::prefix('wip-issue')->name('wip-issue.')->group(function () {

    route::get('dev',  function() {


        // $newMesReviewIssueHeader = \App\Models\PM\PtpmMesReviewIssueHeaders::where('issue_header_id', 1529)
        //                             ->first();
        // $lines  =  $newMesReviewIssueHeader->mesReviewIssueLines;
        // foreach ($lines as $key => $line) {
        //     // $xxx =  ;
        //     // dd($line->issue_line_id , '1080000S5');
        //     if($line->ptctMfgFormula->item_number = '1002000S5'){
        //         dd($line->issue_line_id, 'xxx');
        //     }
        // $newPost = $post->replicate();
        // $newPost->created_at = Carbon::now();
        // $newPost->save();
        // $formula=  \App\Models\PM\PtctMfgFormulaV::whereRaw("(formula_id,routing_id,recipe_id)= (select ptp.formula_id,ptp.routing_id, ptp.recipe_id from ptpm_summary_batch_v ptp where batch_no =  '65M0213-001')")
        //             // ->when($itemClassificationCode, function($q) use ($itemClassificationCode){
        //             //     $q->where('item_classification_code', $itemClassificationCode);
        //             // })
        //             ->where('item_classification_code', '01')
        //             ->where('organization_id', auth()->user()->organization_id)
        //             ->where('reference_item_number', '!=' , null)
        //             // ->where('item_number', '1080RCT/KOREA')
        //             ->get();
        // dd($formula);
        // // dd();
        // // dd($formula);
            $lines =  \App\Models\PM\PtpmMesReviewIssueLines::where('attribute10', null)
                        ->where('leaf_formula')
                        ->get();



            foreach ($lines as $line) {
                # code...
            }
        //     $newPost = $old->replicate();
        //     // $newPost                         = new PtpmMesReviewIssueLines;
        //     // $newPost->issue_line_id          = PtpmMesReviewIssueLines::max('issue_line_id') + 1;
        //     // $newPost->issue_header_id        = $mesReviewIssueHeader->issue_header_id;
        //     $newPost->organization_id        = $formula->setupMfgDeptVLByUserOrg->from_organization_id;
        //     $newPost->subinventory_code      = $formula->setupMfgDeptVLByUserOrg->from_subinventory;
        //     $newPost->line_num               = $formula->line_no;
        //     $newPost->formula_id             = $formula->formula_id;
        //     $newPost->formulaline_id         = $formula->formulaline_id;
        //     $newPost->inventory_item_id      = $formula->inventory_item_id;
        //     // $newPost->lot_number             = $line->lot_number;

        //     // $newPost->web_batch_no           = $webBatchNo;
        //     $newPost->created_by             = auth()->user()->user_id;
        //     $newPost->created_at             = now();
        //     $newPost->record_status          = "INSERT";
        //     $newPost->leaf_formula           = $formula->taxItem->leaf_fomula;
        //     $newPost->transaction_type_id    = $formula->setupMfgDeptVLByUserOrg->transaction_type_id;
        //     // $newPost->confirm_uom_code       = $line->confirm_uom_code;
        //     $newPost->locator_id             =  $formula->setupMfgDeptVLByUserOrg->from_locator_id;
        //     // $newPost->attribute15            = $line['onhand_quantity'];
        //     // $newPost->attribute14            = $mesReviewIssueHeader->ingridient_group_code;
        //     // $newPost->attribute13            = $parentLineId;
        //     $newPost->attribute12            = $formula->attribute12;
        //     $newPost->attribute11            = $formula->taxItem->tobacco_ingrident_type;
        //     $newPost->attribute10            = $formula->taxItem->formulaline_id;
        //     $newPost->save();

        dd('xxx');
            // $newPost->save();
        // dd($formulasV->pluck('reference_item_number' ,'item_number'));
        // foreach ($lines as $key => $line) {
        //     // $xxx =  ;
        //     // dd($line->issue_line_id , '1080000S5');
        //     if($line->ptctMfgFormula->item_number = '1002RCT/KOREA'){
        //         dd($line->issue_line_id, 'xxx');
        //     }
        //     // $f =  \App\Models\PM\PtctMfgFormulaV::where('reference_item_number' ,  $line->ptctMfgFormula->item_number)->first(); 

        //     // if($f->){
        //     //     dd($f);
        //     // }
        // }

        
        // dd($f);

        // $uLines = $newMesReviewIssueHeader->mesReviewIssueLines()
        //                             ->get()
        //                             ->sortBy('ptctMfgFormula.item_number');
        // dd($uLines);
            // $err =  [];
            // $lines  =  PtpmMesReviewIssueLines::where('issue_header_id', '1111')
            //         // ->where('interface_msg', '!=' , null)
            //         ->update(['interface_status' => 'S']);
            // dd($lines);
            // $err = $lines->pluck('interface_msg' , 'interface_msg')->implode(',');

            // $line = PtpmMesReviewIssueLines::find(6536);
            // $newPost = $line->replicate();
            // $newPost->line_num  = 4;
            // $newPost->formula_id = 72457;
            // $newPost->inventory_item_id = 21963;
            // $newPost->attribute15  = 42000;
            // $newPost->save();

            // dd($line);
            // // $collection->implode(',');
                    // dd($xxx->value());
            //     // ->where('product_item_number','100400023')
            //     ->get(
            //         [
            //             'issue_line_id', 
            //             'attribute14', 
            //             'formulaline_id',
            //             'organization_id',
            //             'formulaline_id',
            //             'attribute11'
            //             ]
            //         );
            //     foreach ($lines as $key => $line) {
            //         $line->attribute11 = $line->mfgFormula->tobacco_ingrident_type;
            //         $line->save();
            //     }
                    // ->mfgFormula
            // route('pm.ajax.find-header', 1)

            dd('xxx');
        dd(
           
            // \App\Models\PM\PtpmMesReviewIssueHeaders::selectRaw('issue_header_id, attribute15')
            //     ->where('attribute15', 687)
            //     ->orWhere('issue_header_id' , 687)
            //     ->first()
            //     ->childHeaders
            //     ->count()

        );
        // $x = PtpmMesReviewIssueLines::where('issue_header_id', 459)
        // ->update([
        //         'record_status' => 'INSERT',
        //         'interface_status' => 'S',
        //         'interface_msg' => null]
        // );
        // dd($x);
    });

    Route::get('/', [WipIssuesController::class, 'index'])->name('index');
    Route::get('/casing-flavor', [WipIssuesController::class, 'casingFlavorIndex'])->name('casing-flavor-index');
    Route::get('/issue', [WipIssuesController::class, 'wipIssueAll'])->name('issue');
    Route::get('/cut_of', [WipIssuesController::class, 'wipIssueCutOF'])->name('cut_of');
    Route::get('/stamps', [WipIssuesController::class, 'stamp'])->name('stamps');
    // Route::get('/{id}', [MaterialRequestController::class, 'show'])->name('show');
});



// Route::prefix('wip-issue')->name('wip-issue.')->group(function () {

//     // Route::get('/{id}', [MaterialRequestController::class, 'show'])->name('show');
// });




