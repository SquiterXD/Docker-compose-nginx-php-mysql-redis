<?php


namespace App\Models\PM;

use App\Models\PM\Cast\DateCast;
use App\Models\PM\PtpmTransferObjective;
use App\Models\PM\PtpmTransferStatus;
use App\Models\OrgOrganizationDefinition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmProductTransferH extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'PTPM_PRODUCT_TRANSFER_H';
    public $primaryKey = 'transfer_header_id';
    public $timestamps = false;

    protected $dates = [ 'product_date', 'transfer_date' ];

    protected $appends = [
        'can', 'product_date_format', 'transfer_date_format', 'organization'
    ];

    public function objective()
    {
        return $this->belongsTo(PtpmTransferObjective::class, 'transfer_objective','lookup_code');
    }

    public function status()
    {
        return $this->belongsTo(PtpmTransferStatus::class, 'transfer_status','lookup_code');
    }

    public function lines()
    {
        return $this->belongsTo(\App\Models\PM\PtpmProductTransferL::class, 'transfer_header_id','transfer_header_id');
    }

    public function scopeIsTransfered($q)
    {
        return $q->where('transfer_status', 2);
    }

    public function getCanAttribute()
    {
        $can = (object)[];
        $can->edit = true;
        $can->transfer = false;
        $can->cancel_transfer = false;

        if ($this->transfer_header_id) {

            switch ($this->transfer_status) {
                case '1': // ยังไม่ส่งข้อมูล
                    $can->edit = true;
                    $can->transfer = true;
                    $can->cancel_transfer = true;
                    break;
                case '2': // ส่งข้อมูลเรียบร้อย
                    $can->edit = false;
                    $can->transfer = false;
                    $can->cancel_transfer = true;
                    break;
                case '3': // WMS ยืนยันการดึงข้อมูล
                    $can->edit = false;
                    $can->transfer = false;
                    $can->cancel_transfer = false;
                    break;
                case '4': // ยกเลิกการขอเบิก
                    $can->edit = false;
                    $can->transfer = false;
                    $can->cancel_transfer = false;
                    break;
            }
        }
        return $can;
    }


    function getOrganizationAttribute()
    {
        $organizationId = $this->organization_id ?? getDefaultData()->organization_id;
        $data = OrgOrganizationDefinition::find($organizationId);
        return $data;
    }

    function getProductDateFormatAttribute()
    {
        if ($this->product_date) {
            return parseToDateTh($this->product_date);
        }
        return '';
    }


    function getTransferDateFormatAttribute()
    {
        if ($this->transfer_date) {
            return parseToDateTh($this->transfer_date);
        }
        return '';
    }

    // function getIsOtherObjectiveAttribute()
    // {
    //     if ($this->objective_code) {
    //         return $this->objective_code == 3;
    //     }
    //     return false;
    // }

    function interface()
    {
        $header = $this;
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                o_result    VARCHAR2(4000);
            BEGIN
                ptpm_web_pd_inf_wms_pkg.main_process(
                    i_transfer_number     => '{$header->transfer_number}'
                    ,o_result            => :o_result
                );
                dbms_output.put_line(o_result);
            END;

        ";

        \Log::info('PMP0041 INF', [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':o_result', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info('PMP0041 INF', [$result]);
        return $result;
    }

    public function scopeSearch($query, $keywords)
    {

        // transfer_number
        if (array_key_exists("transfer_number", $keywords)) {
            if ($keywords['transfer_number']) {
                $query->where(function ($q) use ($keywords) {
                    $q->where('transfer_number', 'like', '%' . $keywords['transfer_number'] . '%');
                });
            }
        }
        
        // transfer_status
        if (array_key_exists("transfer_status", $keywords)) {
            if ($keywords['transfer_status']) {
                $query->where('transfer_status', $keywords['transfer_status']);
            }
        }

        // to_locator_id
        if (array_key_exists("to_locator_id", $keywords)) {
            if ($keywords['to_locator_id']) {
                $query->where('attribute11', $keywords['to_locator_id']);
            }
        }

        // transfer_objective
        if (array_key_exists("transfer_objective", $keywords)) {
            if ($keywords['transfer_objective']) {
                $query->where('transfer_objective', $keywords['transfer_objective']);
            }
        }

        
        // product_date
        if (array_key_exists("product_date", $keywords)) {
            if ($keywords['product_date']) {
                $query->whereDate('product_date', parseFromDateTh($keywords['product_date']));
            }
        }

        // product_date_from
        if (array_key_exists("product_date_from", $keywords)) {
            if ($keywords['product_date_from']) {
                $query->where('product_date', '>=', parseFromDateTh($keywords['product_date_from'])." 00:00:00");
            }
        }
        // product_date_to
        if (array_key_exists("product_date_to", $keywords)) {
            if ($keywords['product_date_to']) {
                $query->where('product_date', '<=', parseFromDateTh($keywords['product_date_to'])." 23:59:59");
            }
        }

        // transfer_date
        if (array_key_exists("transfer_date", $keywords)) {
            if ($keywords['transfer_date']) {
                $query->whereDate('transfer_date', parseFromDateTh($keywords['transfer_date']));
            }
        }

        // transfer_date_from
        if (array_key_exists("transfer_date_from", $keywords)) {
            if ($keywords['transfer_date_from']) {
                $query->where('transfer_date', '>=', parseFromDateTh($keywords['transfer_date_from'])." 00:00:00");
            }
        }
        // transfer_date_to
        if (array_key_exists("transfer_date_to", $keywords)) {
            if ($keywords['transfer_date_to']) {
                $query->where('transfer_date', '<=', parseFromDateTh($keywords['transfer_date_to'])." 23:59:59");
            }
        }

        // inventory_item_id
        if (array_key_exists("inventory_item_id", $keywords)) {
            if ($keywords['inventory_item_id']) {
                $query->whereHas('lines', function($q) use ($keywords) {
                    $q->where('inventory_item_id', $keywords['inventory_item_id']);
                });
            }
        }

        // transfer_objective
        if (array_key_exists("transfer_objective", $keywords)) {
            if ($keywords['transfer_objective']) {
                $query->where('transfer_objective', $keywords['transfer_objective']);
            }
        }

        return $query;

    }

    function cancelInterface()
    {
        $header = $this;
        $db     =   \DB::connection('oracle')->getPdo();
        $sql    =   "
            DECLARE
                output    VARCHAR2(20);
            BEGIN
                :output := ptpm_web_pd_inf_cancel_pkg.main('$header->transfer_number');
                dbms_output.put_line('output ='||output);
            END;
        ";

        \Log::info('cancel PMP0041 INF', [$sql]);
        $sql = preg_replace("/[\r\n]*/","",$sql);
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':output', $result['status'], \PDO::PARAM_STR, 4000);
        $stmt->execute();

        \Log::info('PMP0041 INF', [$result]);
        return $result;
    }

    public function canCancelAfterInf()
    {
        $programCode = $this->program_code;
        $transferHeaderId = $this->transfer_header_id;
        $data = collect(\DB::select("
            SELECT   count(PMTI.transaction_header_id) count_cancel_line
            FROM    PTWMS_MTL_TRANS_INTERFACE PMTI
                    , PTWMS_MTL_TRANS_LOTS_INTERFACE PMTLI
                    , (
                        select 
                                rec_h.transfer_header_id,
                                rec_l.transaction_qty,
                                rec_l.transaction_uom,
                                rec_h.transfer_date,
                                rec_l.subinventory_from,
                                rec_l.locator_id_from,
                                rec_l.subinventory_to,
                                rec_l.locator_id_to,
                                rec_l.organization_id_to,
                                rec_l.lot_number,
                                rec_h.program_code
                                --, rec_l.*
                        from    ptpm_product_transfer_h rec_h
                                , ptpm_product_transfer_l rec_l
                        where   1=1
                        and     rec_h.transfer_header_id = rec_l.transfer_header_id
                        and     rec_l.deleted_at is null
                        and     rec_l.interface_status = 'S'
                    ) web

            WHERE   1=1
            --AND     PMTI.ATTRIBUTE14 = 'I'
            AND     PMTI.ATTRIBUTE13 = '$programCode'
            --## PMTLI
            AND     PMTI.TRANSACTION_INTERFACE_ID = PMTLI.TRANSACTION_INTERFACE_ID (+)
            and     PMTI.transaction_header_id = $transferHeaderId
            and     PMTI.ATTRIBUTE14 = 'C'

            -- WEB
            AND PMTI.ATTRIBUTE13            = web.program_code
            and PMTI.transaction_header_id  = web.transfer_header_id
            and PMTI.transaction_quantity   = web.transaction_qty
            and PMTI.transaction_uom        = web.transaction_uom
            and TRUNC(PMTI.transaction_date) = TRUNC(web.transfer_date)
            and PMTI.subinventory_code      = web.subinventory_from
            and PMTI.locator_id             = web.locator_id_from
            and PMTI.transfer_subinventory  = web.subinventory_to
            and PMTI.transfer_locator       = web.locator_id_to
            and PMTI.transfer_organization  = web.organization_id_to
            and PMTLI.lot_number            = web.lot_number
        "));

        $countRequestLines = PtpmProductTransferL::where('transfer_header_id', $transferHeaderId)->where('interface_status', 'S')->count();
        $result =  $countRequestLines == ($data->first()->count_cancel_line ?? 0) && $this->transfer_status == 3;
        return $result;
    }
}
