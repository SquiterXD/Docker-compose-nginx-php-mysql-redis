<?php

namespace App\Repositories\OM;

use App\Models\OM\Customers;
use App\Models\OM\Customers\Domestics\CustomerShipSites;
use App\Models\OM\Promotions\UomV;
use App\Models\OM\SaleConfirmation\ProformaInvoiceHeaders;
use App\Models\OM\SaleConfirmation\ProformaInvoiceLines;
use App\Models\OM\SequenceEcoms;
use App\Models\Ptom\PtomClaimHeader;
use App\Models\Ptom\PtomClaimLine;
use Illuminate\Support\Facades\DB;

class ProformaInvoiceRepo
{
    protected $headers, $lines, $cusShip;

    public function __construct(ProformaInvoiceHeaders $headers, ProformaInvoiceLines $lines, CustomerShipSites $cusShip)
    {
        $this->headers = $headers;
        $this->lines   = $lines;
        $this->cusShip   = $cusShip;
    }
    public function getListsInvoiceNumber($request) {
        $key = collect($request->key)->map(function($item) {
            return (int)$item;
        });
        $items = $this->headers
        ->select($this->headers->getTable() . '.*', $this->cusShip->getTable() . ' .ship_to_site_name as ship_to_site_name', $this->cusShip->getTable() . '.country_name')
        ->join($this->cusShip->getTable(), $this->cusShip->getTable() . '.ship_to_site_id', '=', $this->headers->getTable() . '.ship_to_site_id')
        ->whereIn('PI_HEADER_ID', $key)
        // ->where($this->headers->getTable() . '.customer_id', $customer->customer_id)
        ->orderBy($this->headers->getTable() . ".pi_number", 'desc')
        ->first();

        $items->uomV = UomV::get();
        return $items;
        return $this->headers->whereIn('PI_HEADER_ID', $key)->get();
    }
    
    public function getInvoice($request)
    {
        $customer = Customers::where('customer_number', $request->company_number)->first();
        if (empty($customer)) return false;
        $items = $this->headers
            ->select($this->headers->getTable() . '.*', $this->cusShip->getTable() . ' .ship_to_site_name as ship_to_site_name', $this->cusShip->getTable() . '.country_name')
            ->join($this->cusShip->getTable(), $this->cusShip->getTable() . '.ship_to_site_id', '=', $this->headers->getTable() . '.ship_to_site_id')
            ->where('pick_release_status', 'Confirm')
            ->where($this->headers->getTable() . '.customer_id', $customer->customer_id)
            ->orderBy($this->headers->getTable() . ".pi_number", 'desc')
            ->get();

        $items = $items->map(function ($item) {
            $item->lines = $this->lines
                ->where('pi_header_id', $item->pi_header_id)
                ->with('sequenceEcoms')
                ->get();
            // $claim_header = PtomClaimHeader::where('invoice_id', $item->pi_header_id)->first();
            
            // $claim_header = PtomClaimHeader::where('invoice_id',0)->first();
            // $item->claim_header = $claim_header;
            // $item->claim_doc_number = $claim_header->claim_number ?? '';
            // $item->claim_doc_date = !empty($claim_header->claim_date) ? \Carbon\Carbon::parse($claim_header->claim_date)->format('d/m/Y') : '';
            // $item->symptom_description = $claim_header->symptom_description ?? '';
            $item->lines = $item->lines->map(function ($line) use ($item) {
                // if ($claim_header) {
                //     $hasLine = PtomClaimLine::where('claim_header_id', $claim_header->claim_header_id)
                //         ->where('item_code', $line->item_code)
                //         ->first();
                //     $line->enter_qty = $hasLine->claim_quantity ?? '';
                //     $line->enter_uom = $hasLine->uom_code ?? '';
                  
                //     $line->claim_quantity_cbb = $hasLine->claim_quantity_cbb ?? '';
                //     $line->claim_quantity_carton = $hasLine->claim_quantity_carton ?? '';
                //     $line->claim_quantity_pack = $hasLine->claim_quantity_pack ?? '';
                //     if(!empty($hasLine))
                //         $line->checked = $hasLine->claim_quantity_pack >= 0 ? true : false;
                // }
                $uom = DB::table('PTOM_UOM_V')->where('export', 'Y')->where('uom_code', $line->uom_code)->first();
                $line->uom_description = $uom->description;
                if (!empty($uom)) {
                    $line->uom_master = DB::table('PTOM_UOM_V')->where('uom_class', $uom->uom_class)->get();

                    if (!empty($line->uom_master) && $line->uom_master[0]->uom_class == 'บุหรี่') {
                        $item->type_line_cigarette = true;
                    } else {
                        $item->type_line_cigarette = false;
                    }
                } else {
                    $line->uom_master = [];
                }

                return $line;
            });
            return $item;
        });

        return $items;
    }

    public function storeImage($request)
    {
    }
}
