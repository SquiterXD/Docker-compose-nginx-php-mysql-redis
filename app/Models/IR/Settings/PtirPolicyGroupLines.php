<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtirPolicyGroupLines extends Model
{
    use HasFactory;
    protected $table = "ptir_policy_group_lines";
    public $primaryKey = 'group_line_id';
    public $timestamps = false;

    private $limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_header_id',
        'year',
        'start_date',
        'end_date',
        'revenue_stamp',
        'tax',
        'premium_rate',
        'prepaid_insurance',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date'
    ];

    /**
     * Get all group lines
     */
    public function getAllGroupLines($id)
    {
        $collection = DB::table('ptir_policy_group_lines as a')->select(DB::raw("distinct to_char(add_months(a.start_date, 6516), 'dd/mm/yyyy') as start_date, 
                                                                                 to_char(add_months(a.end_date, 6516), 'dd/mm/yyyy') as end_date, 
                                                                                 to_number(a.year)+543 as year"), 
                                                                                 'a.revenue_stamp', 
                                                                                 'a.tax', 
                                                                                 'a.premium_rate', 
                                                                                 'a.prepaid_insurance', 
                                                                                 'a.group_line_id')
                                                              ->where('a.group_header_id', $id)
                                                              ->orderBy('year', 'desc')
                                                              ->get();

       return $collection;                                                         
    }

    public function getCalculateLineLov($policyId, $strDate, $endDate)
    {
        $collection = DB::table('ptir_policy_group_lines as a')->select('a.revenue_stamp', 'a.tax', 'a.premium_rate', 'prepaid_insurance')
                                                               ->join('ptir_policy_group_sets as b', 'a.group_set_id', '=', 'b.group_set_id')
                                                               ->whereRaw("b.policy_set_header_id = ?
                                                                           and start_date >= to_date(?, 'dd/mm/yyyy')
                                                                           and end_date <= to_date(?, 'dd/mm/yyyy')", [$policyId, $strDate, $endDate])
                                                               ->first();
                                                            
        return $this->objectCalculate($collection);
    }

    private function objectCalculate($collection)
    {
        $obj = new \stdClass();
        $obj->revenue_stamp     = isset($collection->revenue_stamp) ? $collection->revenue_stamp : '';
        $obj->tax               = isset($collection->tax) ? $collection->tax : '';
        $obj->premium_rate      = isset($collection->premium_rate) ? $collection->premium_rate : '';
        $obj->prepaid_insurance = isset($collection->prepaid_insurance) ? $collection->prepaid_insurance : '';

        return $obj;
    }

    public static function updateGroupLine($data)
    {
        $db = PtirPolicyGroupLines::find($data['group_line_id']);
        $db->year                   = $data['year'];
        $db->start_date             = $data['start_date'];
        $db->end_date               = $data['end_date'];
        $db->revenue_stamp          = $data['revenue_stamp'];
        $db->tax                    = $data['tax'];
        $db->premium_rate           = $data['premium_rate'];
        $db->prepaid_insurance      = $data['prepaid_insurance'];
        $db->updated_at             = $data['updated_at'];
        $db->last_updated_by        = $data['last_updated_by'];
        $db->last_update_date       = $data['last_update_date'];
        $db->save();
    }

    public static function duplicateCheck($lineId, $headerId)
    {
        $collection = PtirPolicyGroupLines::where('group_header_id', $headerId)
                                          ->where('group_line_id', $lineId)
                                          ->first();
        if ($collection == null) 
        {
            return true;
        }

        return false;
    }

    public function distributions()
    {
        return $this->hasMany('App\Models\IR\Settings\PtirPolicyGroupDists', 'group_line_id', 'group_line_id');
    }
}
