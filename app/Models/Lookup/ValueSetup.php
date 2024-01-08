<?php

namespace App\Models\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValueSetup extends Model
{
    use HasFactory;

    protected $table  = 'PTWEB_LOOKUP_VALUE_SETUP_V';

    public function getSqlData($t)
    {
        if($t != null){
            $getTests = collect(\DB::select($t));
            return  $getTests;
        }
    }

    public function sqlByOrg($sql, $org)
    {
        // dd($sql);
        $sql = str_replace('$org', $org, $sql);

        // dd($sql);
        $getDatas = collect(\DB::select($sql));

        // dd($getDatas);

        return $getDatas;
        // return $getTests;

    }
    
    public function organization($orgCode, $programCode = null)
    {
        // dd($org, $programCode);
        if ($programCode == 'PMS0040') {

            $org = \App\Models\OrgOrganizationDefinition::where('organization_id', $orgCode)->first();



            $organization = $org ? $org->organization_code . ' : ' . $org->organization_name : null;

            return $organization;

        } else {

            $org = \App\Models\OrgOrganizationDefinition::where('organization_code', $orgCode)->first();

            $organization = $org ? $org->organization_code . ' : ' . $org->organization_name : null;

            return $organization;

        }
        
    }
}
