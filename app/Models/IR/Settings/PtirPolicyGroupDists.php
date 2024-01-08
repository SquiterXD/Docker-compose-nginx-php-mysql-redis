<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtirPolicyGroupDists extends Model
{
    use HasFactory;
    protected $table = "ptir_policy_group_dists";
    public $primaryKey = 'group_distribution_id';
    public $timestamps = false;

    private $limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_line_id',
        'group_header_id',
        'company_id',
        'company_code',
        'company_percent',
        'user_policy_number',
        'comments',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date',
        'default_diff_amount'
    ];

    /**
     * Get all group dists
     */
    public function getAllGroupDists($lineId, $groupHeaderId)
    {
        $collection = PtirPolicyGroupDists::select('group_distribution_id', 'group_line_id', 'group_header_id', 
                                                   'company_code', 'company_percent', 'comments', 'company_id', 'user_policy_number', 'default_diff_amount')
                                            ->where('group_line_id', $lineId)
                                            ->where('group_header_id', $groupHeaderId)
                                            ->orderBy('company_code', 'asc')
                                            ->get();
       
        return $collection;
    }

    public static function updateGroupDists($data)
    {
        $db = PtirPolicyGroupDists::find($data['group_distribution_id']);
        $db->company_code         = $data['company_code'];
        $db->company_percent      = $data['company_percent'];
        $db->company_id           = $data['company_id'];
        $db->comments             = $data['comments'];
        $db->user_policy_number   = $data['user_policy_number'];
        $db->updated_at           = $data['updated_at'];
        $db->last_updated_by      = $data['last_updated_by'];
        $db->last_update_date     = $data['last_update_date'];
        $db->default_diff_amount  = $data['default_diff_amount'];
        $db->save();
    }

    public static function duplicateCheck($companyId, $lineId)
    {
        $collection = PtirPolicyGroupDists::where('company_id', $companyId)
                                          ->where('group_line_id', $lineId)
                                          ->first();

        if ($collection == null) 
        {
            return true;
        }

        return false;
    }

    public function getPercent($groupHeaderId, $year) 
    {
        $collection = DB::table('ptir_policy_group_dists as a')->select('a.group_distribution_id', 
                                                                        'a.company_code', 
                                                                        'a.company_percent',
                                                                        'b.company_number',
                                                                        'b.company_name',
                                                                        'a.company_id')
                                                                ->leftJoin("ptir_companies as b", 'a.company_id', '=', 'b.company_id')
                                                                ->join("ptir_policy_group_lines as c", 'a.group_line_id', '=', 'c.group_line_id')
                                                                ->where('a.group_header_id', $groupHeaderId)
                                                                ->where('c.year', $year)
                                                                ->get();

        return $collection;
    }

    public function company()
    {
        return $this->belongsTo('App\Models\IR\Settings\PtirCompanies', 'company_code', 'company_number');
    }
}

