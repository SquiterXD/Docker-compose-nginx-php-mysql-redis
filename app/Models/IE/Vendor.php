<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'PTIE_PO_VENDORS_V';

    public function bank()
    {
        return $this->hasOne('App\Models\IE\SupplierBankV', 'vendor_site_id', 'vendor_site_id')->where('org_id', $this->org_id);
    }

    public function scopeNotEmp($query)
    {
        // return $query->whereNull('attribute5');
        return;
    }
    
    public function getTaxAddress()
    {
        $result = \DB::select("select distinct pos.address_line1||address_line2||address_line3 as tax_address
                from po_vendor_sites_all pos, po_vendors pov 
                where  pov.vendor_id = pos.vendor_id and pos.vendor_id = :VENDOR_ID 
                and pos.vendor_site_id = :VENDOR_SITE_ID 
                and (pov.vendor_name not like '%เจ้าหนี้%' and pov.vendor_name not like '%ลูกหนี้%')"
                , ['VENDOR_ID' => $this->vendor_id, 'VENDOR_SITE_ID'=> $this->vendor_site_id]);

        return count($result) ? $result[0]->tax_address : null;
    }

    public function getBranchNumber()
    {
        $result = \DB::select("select distinct  hzps.attribute1 as branch_no
                from hz_party_sites hzps, po_vendor_sites_all pos, po_vendors pov 
                where  pos.vendor_id = :VENDOR_ID 
                and pos.vendor_site_id = :VENDOR_SITE_ID 
                and (pov.vendor_name not like '%เจ้าหนี้%' and pov.vendor_name not like '%ลูกหนี้%') 
                and hzps.party_site_id = :PARTY_SITE_ID 
                and hzps.party_site_id = pos.party_site_id and pov.vendor_id = pos.vendor_id"
                , ['VENDOR_ID' => $this->vendor_id, 'VENDOR_SITE_ID'=> $this->vendor_site_id, 'PARTY_SITE_ID' => $this->party_site_id]);

        return count($result) ? $result[0]->branch_no : null;
    }

    public function getTaxID()
    {
        $result = \DB::select("select distinct nvl(pov.vat_registration_num, pov.num_1099) as tax_id
                from po_vendors pov where  pov.vendor_id = :VENDOR_ID 
                and (pov.vendor_name not like '%เจ้าหนี้%' and pov.vendor_name not like '%ลูกหนี้%')", ['VENDOR_ID' => $this->vendor_id]);

        return count($result) ? $result[0]->tax_id : null;
    }

    public function mainAccount()
    {
        return $this->hasOne('App\Models\IE\FNDListOfValues', 'flex_value', 'segment9')->account();
    }

    public function subAccount()
    {
        return $this->hasOne('App\Models\IE\FNDListOfValues', 'flex_value', 'segment10')->subAccount()->where('parent_flex_value_low', $this->segment9);
    }
}
