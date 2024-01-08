<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use stdClass;
use Illuminate\Support\Facades\DB;

use App\Models\IR\Views\PtirPolicyTypeView;
class PtirPolicySetHeaders extends Model
{
    use HasFactory;

    protected $table = "ptir_policy_set_headers";
    public $primaryKey = 'policy_set_header_id';
    public $timestamps = false;

    private $limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'policy_set_number',
        'policy_set_description',
        'policy_type_code',
        'policy_age',
        'account_id',
        'include_tax_flag',
        'group_code',
        'policy_category_code',
        'active_flag',
        'gl_expense_account_id',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date'
    ];

    /**
     * Get all policy header lov
     */
    public function getPolicySetHeadersLov($id, $keyword, $type, $type2)
    {
        $id      = (isset($id)) ? $id.'%' : '%';
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';

        // dd($id, $keyword, $type, $type2);

        $collection = PtirPolicySetHeaders::select('ptir_policy_set_headers.policy_set_header_id', 'ptir_policy_set_headers.policy_set_number', 'ptir_policy_set_headers.policy_set_description', 'ptir_policy_category_v.meaning')
                                           ->join('ptir_policy_category_v', 'ptir_policy_category_v.lookup_code', '=', 'ptir_policy_set_headers.policy_category_code')
                                           ->where('ptir_policy_set_headers.policy_set_header_id', 'like', $id)
                                           ->whereRaw("(ptir_policy_set_headers.policy_set_number like ? or ptir_policy_set_headers.policy_set_description like ?)
                                                       and ptir_policy_set_headers.active_flag = 'Y'
                                                       and ptir_policy_set_headers.policy_category_code in (nvl(?, policy_category_code), ?)", [$keyword, $keyword, $type, $type2])
                                           ->take($this->limit)
                                           ->orderBy('ptir_policy_set_headers.policy_set_number', 'asc')
                                           ->get();

        return $collection;
    }


    /**
     * Get all policy header
     */
    public function getAllPolicySetHeaders($id, $active_flag)
    {
        $collection  = DB::table('ptir_policy_set_headers as a')->select('a.policy_set_header_id', 'a.policy_set_number', 'a.policy_set_description',
                                                                         'b.lookup_code as policy_type_code','b.description as policy_type_description', 'a.active_flag')
                                                                ->leftJoin('ptir_policy_type as b', 'a.policy_type_code', '=', 'b.lookup_code')
                                                                ->whereRaw('a.policy_set_header_id = nvl(?, a.policy_set_header_id)
                                                                            and a.active_flag = nvl(?, a.active_flag)', [$id, $active_flag])
                                                                ->orderBy('a.policy_set_number', 'asc')
                                                                ->get();

        return $collection;
    }

     /**
     * Get specified policy header
     */
    public function getPolicySetHeaders($id)
    {
        $collection  = PtirPolicySetHeaders::select('policy_set_header_id', 'policy_set_number', 'policy_set_description', 'policy_type_code',
                                                    'policy_age', 'account_id', 'include_tax_flag', 'group_code', 'policy_category_code',
                                                    'active_flag', 'gl_expense_account_id')
                                            ->where('policy_set_header_id', $id)
                                            ->first();

        return $collection;
    }

    public function getObjectPolicySetHeaders($id)
    {
        $data = $this->getPolicySetHeaders($id);
        $obj = new stdClass();
        $obj->policy_set_header_id   = (isset($data->policy_set_header_id)) ? $data->policy_set_header_id : '';
        $obj->policy_set_number      = (isset($data->policy_set_number)) ? $data->policy_set_number : '';
        $obj->policy_set_description = (isset($data->policy_set_description)) ? $data->policy_set_description : '';
        $obj->policy_type_code       = (isset($data->policy_type_code)) ? $data->policy_type_code : '';
        $obj->policy_age             = (isset($data->policy_age)) ? $data->policy_age : '';
        $obj->account_id             = (isset($data->account_id)) ? $data->account_id : '';
        $obj->include_tax_flag       = (isset($data->include_tax_flag)) ? $data->include_tax_flag : '';
        $obj->group_code             = (isset($data->group_code)) ? $data->group_code : '';
        $obj->policy_category_code   = (isset($data->policy_category_code)) ? $data->policy_category_code : '';
        $obj->active_flag            = (isset($data->active_flag)) ? $data->active_flag : '';
        $obj->gl_expense_account_id  = (isset($data->gl_expense_account_id)) ? $data->gl_expense_account_id : '';

        return $obj;
    }

    public function updatePolicySetHeader($data)
    {
        $db = PtirPolicySetHeaders::find($data['policy_set_header_id']);
        $db->policy_set_number       = $data['policy_set_number'];
        $db->policy_set_description  = $data['policy_set_description'];
        $db->policy_type_code        = $data['policy_type_code'];
        $db->policy_age              = $data['policy_age'];
        $db->account_id              = $data['account_id'];
        $db->include_tax_flag        = $data['include_tax_flag'];
        $db->group_code              = $data['group_code'];
        $db->policy_category_code    = $data['policy_category_code'];
        $db->active_flag             = $data['active_flag'];
        $db->gl_expense_account_id   = $data['gl_expense_account_id'];
        $db->last_updated_by         = $data['last_updated_by'];
        $db->updated_at              = $data['updated_at'];
        $db->last_update_date        = $data['last_update_date'];
        $db->save();
    }

    public function updateActiveFlag($data)
    {
        $db = PtirPolicySetHeaders::find($data['policy_set_header_id']);
        $db->active_flag       = $data['active_flag'];
        $db->last_updated_by   = $data['last_updated_by'];
        $db->updated_at        = $data['updated_at'];
        $db->last_update_date  = $data['last_update_date'];
        $db->save();
    }

    public static function duplicateCheck($policyNumber)
    {
        $collection = PtirPolicySetHeaders::where('policy_set_number', $policyNumber)->first();

        if ($collection == null)
        {
            return true;
        }

        return false;
    }

    public function groupSet()
    {
        return $this->belongsTo('App\Models\IR\Settings\PtirPolicyGroupSets', 'policy_set_header_id', 'policy_set_header_id');
    }

    public function scopeSearch($q, $search)
    {
        if ($search->policy_set_header_id) {
            $q->where('policy_set_header_id', $search->policy_set_header_id);
        } else {
            $q;
        }

        if ($search->active_flag) {
            $q->where('active_flag', $search->active_flag);
        } else {
            $q;
        }

        return $q;
    }

    public function policyType()
    {
        return $this->belongsTo(PtirPolicyTypeView::class, 'policy_type_code', 'lookup_code');
    }

    
}
