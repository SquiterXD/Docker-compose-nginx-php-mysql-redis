<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportOwner extends Model
{
    use HasFactory;
    protected $table = 'ptom_transport_owners';
    protected $primaryKey = 'transport_owner_id';
    protected $appends = ['format_date_start', 'format_date_end'];


    public function vendor()
    {
        return $this->belongsTo(PoVendorsV::class, 'vendor_id', 'vendor_id');
    }
    public function getFormatDateStartAttribute()
    {
        return $this->start_date
            ?  \Carbon\Carbon::parse($this->start_date)
            : '';
    }

    public function getFormatDateEndAttribute()
    {
        return $this->end_date
            ? \Carbon\Carbon::parse($this->end_date)
            : '';
    }

}
