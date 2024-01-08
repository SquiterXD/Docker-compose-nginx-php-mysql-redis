<?php

namespace App\Repositories\OM;

use App\Models\OM\Promotions\UomV;
use App\Models\Ptom\PtomClaimHeader;
use App\Models\Ptom\PtomClaimLine;
use Illuminate\Support\Facades\DB;

class ClaimLineRepo
{
    protected $line;
    public function __construct(PtomClaimLine $line)
    {
        $this->line = $line;
    }
    public function store($request, $number, $header)
    {
        $dataLine = [];
     
        $oldHeader = PtomClaimHeader::select('claim_header_id')
            ->where('REF_INVOICE_NUMBER', $request->pick_release_no)
            ->get()
            ->pluck('claim_header_id', 'claim_header_id');

        $oldLines = PtomClaimLine::whereIn('claim_header_id', $oldHeader)->get();

        foreach ($request->lines as $index => $line) {
            if ($line['disabled'] == "false") {
                $data = $this->setDataLine($request, $line, $number, $header, $oldLines);

                if(@$data['status'] === false) return ['status' => false, 'msg' => $data['msg']];
                
                $this->line = new PtomClaimLine;
                foreach ($data as $key => $value) {
                    $this->line->{$key} = $value;
                }
                $this->line->save();
                $dataLine[] = $this->line;

                AttachmentClaimRepo::uploadAttachmentMultiple($line['fs_confirm'], $header, $this->line->claim_line_id, 'OMP0081', 1);

                AttachmentClaimRepo::uploadAttachmentMultiple($line['bs_confirm'], $header, $this->line->claim_line_id, 'OMP0081', 2);

                AttachmentClaimRepo::uploadAttachmentMultiple($line['gd_confirm'], $header, $this->line->claim_line_id, 'OMP0081', 3);
            }
        }

        return $dataLine;
    }
    public function setDataLine($request, $line, $number, $header, $oldLine)
    {
        #ดึงข้อมูลไลน์เดิมมาตรวจสอบ
        $oldLine = $oldLine->where('item_id', $line['item_id']);


        $userId = optional(auth()->user())->user_id ?? -1;
        $claimUom = UomV::where('domestic','Y')
                    ->where('uom_code', 'CGK')
                    ->value('uom_code');    //พันมวน
        $cbbUom = UomV::where('domestic','Y')
                    ->where('uom_code', 'CGC')
                    ->value('uom_code');    //หีบ
        $cartonUom = UomV::where('domestic','Y')
                    ->where('uom_code', 'CG2')
                    ->value('uom_code');    //ห่อ
        $packUom = UomV::where('domestic','Y')
                    ->where('uom_code', 'CGP')
                    ->value('uom_code');    //ซอง
        $lineUom = UomV::where('domestic','Y')
                    ->where('uom_code', $line['uom_code'])
                    ->value('uom_code');    //รายการ line


        if(count($oldLine) > 0 ) {
            $sumOldLine = $oldLine->sum('claim_quantity');
        }
        
        $convertBase = collect(DB::select("
        select  (apps.inv_convert.inv_um_convert (
                        item_id           => '{$line['item_id']}',
                        organization_id   => 164,
                        PRECISION         => NULL,
                        from_quantity     => '{$line['approve_quantity']}',
                        from_unit         => '{$lineUom}',
                        to_unit           => '{$claimUom}',
                        from_name         => NULL,
                        to_name           => NULL)
                )                                                               result
        from dual
                                                                                        "))->first();

        if(isset($line['claim_quantity_cbb'])||isset($line['claim_quantity_carton'])||isset($line['claim_quantity_pack'])){

            //ในส่วนของระดับ Line ที่เป็นประเภทบุหรี่
            if(isset($line['claim_quantity_cbb'])){
                    $convertCbb = collect(\DB::select("
                                                    select  (apps.inv_convert.inv_um_convert (
                                                                    item_id           => '{$line['item_id']}',
                                                                    organization_id   => 164,
                                                                    PRECISION         => NULL,
                                                                    from_quantity     => '{$line['claim_quantity_cbb']}',
                                                                    from_unit         => '{$cbbUom}',
                                                                    to_unit           => '{$claimUom}',
                                                                    from_name         => NULL,
                                                                    to_name           => NULL)
                                                            )                                                               result
                                                    from dual
                                                                                                                                    "))->first();
            }
            if(isset($line['claim_quantity_carton'])){
                    $convertCarton = collect(\DB::select("
                                                    select  (apps.inv_convert.inv_um_convert (
                                                                    item_id           => '{$line['item_id']}',
                                                                    organization_id   => 164,
                                                                    PRECISION         => NULL,
                                                                    from_quantity     => '{$line['claim_quantity_carton']}',
                                                                    from_unit         => '{$cartonUom}',
                                                                    to_unit           => '{$claimUom}',
                                                                    from_name         => NULL,
                                                                    to_name           => NULL)
                                                            )                                                               result
                                                    from dual
                                                                                                                                    "))->first();
            }
            if(isset($line['claim_quantity_pack'])){
                    $convertPack = collect(\DB::select("
                                                    select  (apps.inv_convert.inv_um_convert (
                                                                    item_id           => '{$line['item_id']}',
                                                                    organization_id   => 164,
                                                                    PRECISION         => NULL,
                                                                    from_quantity     => '{$line['claim_quantity_pack']}',
                                                                    from_unit         => '{$packUom}',
                                                                    to_unit           => '{$claimUom}',
                                                                    from_name         => NULL,
                                                                    to_name           => NULL)
                                                            )                                                               result
                                                    from dual
                                                                                                                                    "))->first();
            }
            $totalClaim =   (isset($convertCbb->result)? $convertCbb->result : 0) + 
                            (isset($convertCarton->result) ? $convertCarton->result : 0) +
                            (isset($convertPack->result) ? $convertPack->result : 0)
                            + ($sumOldLine ?? 0); //ผลรวมของจำนวน หีบ ห่อ ซอง ที่แปลงมาเป็น พันมวน
    }elseif (isset($line['enter_qty'])||isset($line['enter_uom'])) {    

        $claimUom = UomV::where('domestic','Y')
        ->where('uom_code', $line['uom_code']) //แก้ตามที่ประชุม
        ->value('uom_code');    

        $convertBase = collect(\DB::select("
        select  (apps.inv_convert.inv_um_convert (
                        item_id           => '{$line['item_id']}',
                        organization_id   => 164,
                        PRECISION         => NULL,
                        from_quantity     => '{$line['approve_quantity']}',
                        from_unit         => '{$lineUom}',
                        to_unit           => '{$claimUom}',
                        from_name         => NULL,
                        to_name           => NULL)
                )                                                               result
        from dual"))->first();
            $convertCGK = collect(\DB::select("
                                                    select  (apps.inv_convert.inv_um_convert (
                                                                    item_id           => '{$line['item_id']}',
                                                                    organization_id   => 164,
                                                                    PRECISION         => NULL,
                                                                    from_quantity     => '{$line['enter_qty']}',
                                                                    from_unit         => '{$line['enter_uom']}',
                                                                    to_unit           => '{$claimUom}',
                                                                    from_name         => NULL,
                                                                    to_name           => NULL)
                                                            )                                                               result
                                                    from dual
                                                                                                                                    "))->first();                                    
            $totalClaim = $convertCGK->result;
            // dd($totalClaim, $convertCGK);
    } 
        $now = now()->format('Y-m-d H:i:s');

        if(((float)$totalClaim + ($sumOldLine ?? 0)) > (float)$convertBase->result) 
            return ['status'=> false, 'msg' => 'total claim over base claim'];
            
        

        $auth = null;
        $data = [
            'claim_header_id'           => $header,
            'item_id'                   => $line['item_id'],
            'claim_no'                  => $number,
            'item_code'                 => $line['item_code'],
            'item_description'          => $line['item_description'],
            'order_quantity'            => $line['order_quantity'],
            'uom_code'                  => $line['uom_code'],
            'claim_quantity'            => $totalClaim ?? '',
            'claim_uom_code'            => $claimUom ?? '',
            'program_code'              => 'OMP0081',
            'created_by'                => $auth->user_id ?? -1,
            'creation_date'             => $now,
            'last_updated_by'           => $auth->user_id ?? -1,
            // 'last_updated_date'      => $now,
            'created_at'                => $now,
            'updated_at'                => $now,
            'created_by_id'             => $auth->fnd_user_id ?? 0,
            'order_line_id'             => $line['ref_order_line_id'],
            // 'enter_claim_quantity'   => !empty($line['enter_claim_quantity']) ? $line['enter_claim_quantity'] : '',
            // 'enter_claim_uom'        => !empty($line['enter_claim_uom']) ? $line['enter_claim_uom'] : '',
            'claim_quantity_cbb'        => $line['claim_quantity_cbb'] ?? 0,
            'claim_quantity_carton'     => $line['claim_quantity_carton'] ?? 0,
            'claim_quantity_pack'       => $line['claim_quantity_pack'] ?? 0,
            'enter_claim_quantity'       => $line['enter_qty'] ?? 0,
            'enter_claim_uom'       => $line['enter_uom'] ?? 0,
        ];
        return $data;
    }
}
