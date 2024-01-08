<?php

namespace App\Models\INV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoDistributionsAll extends Model
{
    use HasFactory;
    protected $table = 'po_distributions_all';

    public function poHeadersAll()
    {
        return $this->belongsTo('App\Models\INV\PoHeadersAll', 'po_header_id', 'po_header_id');
    }

    public function poLinesAll()
    {
        return $this->belongsTo('App\Models\INV\PoLinesAll', 'po_line_id', 'po_line_id');
    }

    public function perPeopleF()
    {
        return $this->belongsTo('App\Models\INV\PerPeopleF', 'deliver_to_person_id', 'person_id');
    }

    public function parameters()
    {
        return $this->belongsTo('App\Models\INV\MtlParameters', 'destination_organization_id', 'organization_id');
    }
}
