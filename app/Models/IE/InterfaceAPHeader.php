<?php

namespace App\Models\IE;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class InterfaceAPHeader extends Model
{
    protected $table = 'ptw_interface_ap_headers';
    public $primaryKey = 'interface_ap_header_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public function scopeSuccess($query)
    {
        return $query->where('interface_status', 'S');
    }

    public function scopeSearch($query, $search)
    {
        // dd($request->all());
        $vendor_id = $search->supplier_id;
        $preparer = strtoupper($search->preparer);
        $date_from = $search->request_date_from;
        $date_to = $search->request_date_to;
        $invoice_from = strtoupper($search->invoice_no_from);
        $invoice_to = strtoupper($search->invoice_no_to);
        $document_from =  strtoupper($search->document_no_from);
        $document_to =  strtoupper($search->document_no_to);

        if($vendor_id){
            $query->where('vendor_id', $vendor_id);
        }
        if($preparer){
            $user_ids = User::whereRaw("UPPER(name) like '%".$preparer."%'")
                            ->pluck('user_id');
            $query->whereHas('request', function($q) use ($user_ids){
                $q->whereIn('created_by', $user_ids);
            });
        }
        if($date_from && $date_to){
            $oneDate = $date_from == $date_to;
            if($oneDate){
                $query->whereDate('creation_date', Carbon::createFromFormat('d/m/Y', $date_from));
            }else {
                $query->whereBetween('creation_date', [Carbon::createFromFormat('d/m/Y', $date_from)->startOfDay(), Carbon::createFromFormat('d/m/Y', $date_to)->endOfDay()]);
            }
        }elseif($date_from){
            $query->whereDate('creation_date', '>=', Carbon::createFromFormat('d/m/Y', $date_from));
        }elseif($date_to){
            $query->whereDate('creation_date', '<=', Carbon::createFromFormat('d/m/Y', $date_to));
        }
        if($invoice_from && $invoice_to){
            $query->whereRaw("UPPER(invoice_number) >= '".$invoice_from."'")
                ->whereRaw("UPPER(invoice_number) <= '".$invoice_to."'");
        }elseif($invoice_from){
            $query->whereRaw("UPPER(invoice_number) >= '".$invoice_from."'");
        }elseif($invoice_to){
            $query->whereRaw("UPPER(invoice_number) <= '".$invoice_to."'");
        }
        if($document_from && $document_to){
            $query->whereHas('request', function($q) use ($document_from, $document_to){
                $q->where(function ($p) use ($document_from, $document_to) {
                    $p->whereRaw("UPPER(document_no) >= '".$document_from."'")
                        ->whereRaw("UPPER(document_no) <= '".$document_to."'");
                });
            });
        }elseif($document_from){
            $query->whereHas('request', function($q) use ($document_from){
                $q->where(function ($p) use ($document_from) {
                    $p->whereRaw("UPPER(document_no) >= '".$document_from."'");
                });
            });
        }elseif($document_to){
            $query->whereHas('request', function($q) use ($document_to){
                $q->where(function ($p) use ($document_to) {
                    $p->where('document_no', '<=',  $document_to);
                });
            });
        }

        return $query;
    }

    public function lines()
    {
        return $this->hasMany('App\Models\IE\InterfaceAPLine', 'interface_ap_header_id');
    }

    public function documentable()
    {
        return $this->morphTo();
    }

    public function request()
    {
        Relation::morphMap([
            'CASH-ADVANCE' => 'App\Models\IE\CashAdvance',
            'CLEARING' => 'App\Models\IE\CashAdvance',
            'REIMBURSEMENT' => 'App\Models\IE\Reimbursement',
        ]);

        return $this->morphTo(null, 'request_from', 'request_id');
    }

    public function supplier()
    {
        return $this->hasOne('App\Models\IE\Vendor', 'vendor_id', 'vendor_id');
    }

    public function statusPaid()
    {
        return $this->hasOne('App\Models\IE\APInvStatusPaid', 'invoice_num', 'invoice_number');
    }

}
