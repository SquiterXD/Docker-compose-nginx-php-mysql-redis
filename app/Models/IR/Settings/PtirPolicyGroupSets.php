<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtirPolicyGroupSets extends Model
{
    use HasFactory;
    protected $table = "ptir_policy_group_sets";
    public $primaryKey = 'group_set_id';
    public $timestamps = false;

    private $limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_header_id',
        'policy_set_header_id',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date'
    ];

     /**
     * Get all group sets 
     */
    public function getAllGroupSets($id)
    {
        $collection = DB::table('ptir_policy_group_sets as a')->select('b.group_header_id', 'b.group_code', 'b.group_description', 'a.group_set_id', 'a.policy_set_header_id', 'c.policy_set_number', 'c.policy_set_description')
                                                                 ->rightJoin('ptir_policy_group_headers as b', 'a.group_header_id', '=', 'b.group_header_id')
                                                                 ->leftJoin('ptir_policy_set_headers as c', 'a.policy_set_header_id', '=', 'c.policy_set_header_id')
                                                                 ->where('b.group_header_id', $id)
                                                                 ->orderBy('policy_set_number', 'asc')
                                                                 ->get();

        return $collection;
    }

    public function deletePolicyGroupSet($data) 
    {
        DB::table('ptir_policy_group_sets as a')->where('a.group_set_id', $data['group_set_id'])
                                                ->where('a.group_header_id', $data['group_header_id'])
                                                ->delete();
    }

    public function getPremiumRate($id, $dateFrom, $dateTo, $year)
    {
        $collection = DB::table('ptir_policy_group_sets as a')->select('b.revenue_stamp', 'b.tax', 'b.premium_rate', 'b.prepaid_insurance')
                                                             ->join('ptir_policy_group_lines as b', 'a.group_header_id', '=', 'b.group_header_id')
                                                             ->whereRaw("policy_set_header_id = nvl(?, policy_set_header_id)
                                                                         and b.year = nvl(?, to_char(sysdate, 'YYYY'))", [$id, $year])
                                                             ->first();

        return $collection;
    }

    public static function updateGroupSets($data)
    {
        $db = PtirPolicyGroupSets::find($data['group_set_id']);
        $db->policy_set_header_id   = $data['policy_set_header_id'];
        $db->updated_at             = $data['updated_at'];
        $db->last_updated_by        = $data['last_updated_by'];
        $db->last_update_date       = $data['last_update_date'];
        $db->save();
    }

    public static function duplicateCheck($groupId, $policyId)
    {
        $collection = PtirPolicyGroupSets::where('group_header_id', $groupId)
                                          ->where('policy_set_header_id', $policyId)
                                          ->first();

        if ($collection == null) 
        {
            return true;
        }

        return false;
    }

    public function getPolicyId($groupId) 
    {
        $collection = DB::table('ptir_policy_group_sets as a')->select('a.policy_set_header_id', 'b.policy_set_number', 'b.policy_set_description')
                                                              ->join('ptir_policy_set_headers as b', 'a.policy_set_header_id', '=', 'b.policy_set_header_id')
                                                              ->where('a.group_header_id', $groupId)
                                                              ->get();

        return $collection;
    }

    public function getLastRecordRate($policyId) {
        $collection = DB::table('ptir_policy_group_sets as a')->select('b.revenue_stamp', 'b.tax', 'b.premium_rate', 'b.prepaid_insurance')
                                                             ->join('ptir_policy_group_lines as b', 'a.group_header_id', '=', 'b.group_header_id')
                                                             ->whereRaw("a.policy_set_header_id = nvl(?, a.policy_set_header_id) 
                                                                         and group_line_id = (select max(group_line_id) 
                                                                                             from ptir_policy_group_sets a join ptir_policy_group_lines b on a.group_header_id = b.group_header_id
                                                                                             where a.policy_set_header_id = nvl(?, a.policy_set_header_id))", [$policyId, $policyId])
                                                             ->first();

        return $collection; 
    }

    public function header()
    {
        return $this->belongsTo('App\Models\IR\Settings\PtirPolicyGroupHeaders', 'group_header_id');
    }
}