<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IR\Settings\PtirAccountsMapping;

class PtirPolicySetHeadersView extends Model
{
    use HasFactory;
    protected $table = "ptir_policy_set_headers_v";

    public function getGroupLov($id)
    {
        $collection = PtirPolicySetHeadersView::select('group_code', 'group_desc')
                                                ->where('policy_set_header_id', $id)
                                                ->first();

        return $collection;
    }

    // Piyawut A. 20211112
    public function accountMapping()
    {
        return $this->hasOne(PtirAccountsMapping::class, 'account_id', 'account_id');
    }
}
