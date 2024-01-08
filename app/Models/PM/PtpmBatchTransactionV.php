<?php

namespace App\Models\PM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PM\PtpmMfgFormulaV;
use App\Models\PM\Lookup\PtpmItemConvUomV;
use App\Models\PM\PtctMfgFormulaV;

class PtpmBatchTransactionV extends Model
{
    use HasFactory;

    protected $table = 'ptpm_batch_txn1_v';

    public function scopeSelectFiled($q)
    {
        return $q->selectRaw("DISTINCT ORGANIZATION_ID,
                                BATCH_ID,
                                BATCH_NO,
                                TRANSACTION_TYPE_NAME,
                                issue_status,
                                BATCH_STATUS_CODE,
                                BATCH_STATUS,
                                DEPARTMENT_CODE,
                                JOB_TYPE_CODE,
                                JOB_TYPE,
                                WEB_BATCH_STATUS_CODE,
                                WEB_BATCH_STATUS,
                                REQUEST_NUMBER,
                                TOBACCO_INGRIDENT_TYPE,
                                INVENTORY_ITEM_ID,
                                ITEM_NO,
                                ITEM_DESC,
                                BLEND_NO,
                                ORGANIZATION_CODE,
                                SUBINVENTORY_CODE,
                                LOCATOR_ID,
                                LOCATOR_CODE,
                                TRANSACTION_DATE,
                                TRANSACTION_UOM,
                                transaction_quantity,
                                LOT_NUMBER,
                                FORMULALINE_ID,
                                MATERIAL_DETAIL_ID,
                                onhand,
                                REQUIRE_QTY,
                                leaf_formula,
                                uom_name,
                                REF_ISSUE_LINE_ID,
                                casting_flavor_name
                                "
                            );
    }

    public function issueStatus()
    {
        return $this->belongsTo(\App\Models\PM\PtmpIssueStatus::class, 'issue_status', 'lookup_code');
    }

    public function conversionUom($case)
    {
            if($this->organization_code == 'M02' || $this->organization_code == 'M03'){
                $formula = PtctMfgFormulaV::where('formulaline_id', $this->formulaline_id)
                ->first();
            }else {
                $formula = PtpmMfgFormulaV::where('formulaline_id', $this->formulaline_id)
                ->first();
            }




            // dd($formula);
            if($this->transaction_uom == 'LT' ||$this->transaction_uom =='CC1'){
                return  (object)[
                    'productDetailUom'      => 'KG',
                    'productUnitOfMeasure'  => 'กิโลกรัม',
                    'sumTotalQty'           => $this->transaction_quantity,
                    'formula'               => $formula
                ];
            }

            if($case == "total"){
                return  (object)[
                    'productDetailUom'      => "",
                    'productUnitOfMeasure'  => "",
                    'sumTotalQty'           => $this->transaction_quantity,
                    'formula'               => $formula
                ];
            }

            if($case == "total_non_tax"){
                return  (object)[
                    'productDetailUom'      => "",
                    'productUnitOfMeasure'  => "",
                    'sumTotalQty'           => $this->ref_issue_line_id ? 0  : $this->transaction_quantity, // ref_issue_line_id ถ้ามีค่าจะเป็น item ภาษีและเชื่อมไปที่ ptpm_mes_review_issue_lines เพื่อดูว่าเป็น item คู่อะไร
                    'formula'               => $formula
                ];
            }

            if ($case=="uom") {

                // dd($this->itemConvUom() , $formula->inventory_item_id , $this->inventory_item_id,  $this->transaction_uom);
                $productUnitOfMeasure       = $formula->itemConvUom()
                                                ? $formula->itemConvUom()->toUom->unit_of_measure
                                                : $formula->primary_unit_of_measure;
                // dd($formula , $formula->itemConvUom());
                return  (object)[
                    'productDetailUom'      => "",
                    'productUnitOfMeasure'  => $productUnitOfMeasure ?? $this->unit_of_measure,
                    'sumTotalQty'           => "",
                    'formula'               => ""
                ];
            }


            // $productDetailUom           = $formula->itemConvUom()
            //             ? $formula->itemConvUom()->toUom->unit_of_measure
            //             : $formula->product_detail_uom;
            // $productUnitOfMeasure       = $formula->itemConvUom()
            //             ? $formula->itemConvUom()->toUom->unit_of_measure
            //             : $formula->primary_unit_of_measure;

            // $sumTotalQty    = $this->transaction_quantity;

            // return  (object)[
            //     'productDetailUom'      => $productDetailUom,
            //     'productUnitOfMeasure'  => $productUnitOfMeasure ?? $this->unit_of_measure,
            //     'sumTotalQty'           => $sumTotalQty,
            //     'formula'               => $formula
            // ];
            // dd($productDetailUom, $productUnitOfMeasure,$sumTotalQty);
    }

    public function composOnhand($lines, $lot , $formulaLineId)
    {
        $line = $lines->where('lot_number', $lot)
                    ->where('formulaline_id', $formulaLineId)
                    ->first();
        if(!$line){
            return $this->onhand;
        }

        return $line->attribute15;

    }


    // public function itemConvUom()
    // {
    //     $con = PtpmItemConvUomV::where('inventory_item_id', $this->inventory_item_id)
    //             ->where('organization_id', auth()->user()->organization_id)
    //             ->where('from_uom_code', $this->detail_uom)
    //             ->where('to_uom_code', 'KG')
    //             ->first();

    //     return $con;
    // }

}
