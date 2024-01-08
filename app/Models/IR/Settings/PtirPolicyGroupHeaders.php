<?php

namespace App\Models\IR\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use stdClass;

class PtirPolicyGroupHeaders extends Model
{
    use HasFactory;
    protected $table = "ptir_policy_group_headers";
    public $primaryKey = 'group_header_id';
    public $timestamps = false;

    private $limit = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group_code',
        'group_description',
        'active_flag',
        'program_code',
        'created_at',
        'created_by_id',
        'created_by',
        'last_updated_by',
        'creation_date',
        'last_update_date'
    ];

    /**
     * Get policy group header lov
     */
    public function getPolicyGroupHeaderLov($id, $keyword)
    {
        $keyword       = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtirPolicyGroupHeaders::select('group_header_id', 
                                                     'group_code', 
                                                     'group_description')
                                            ->whereRaw("group_header_id = nvl(?, group_header_id)
                                                        and UPPER(group_code) like ? or UPPER(group_description) like ?", 
                                                        [$id, strtoupper($keyword), strtoupper($keyword)])
                                            ->limit($this->limit)
                                            ->orderBy('group_code', 'asc')
                                            ->get();

        return $collection;
    }

    /**
     * Get all policy group header 
     */
    public function getAllPolicyGroupHeaders($id, $activeFlag) 
    {
        $collection = PtirPolicyGroupHeaders::select('group_header_id',
                                                     'group_code', 
                                                     'group_description', 
                                                     'active_flag',
                                                     'group_header_id as uid')
                                            ->whereRaw("group_header_id = nvl(?, group_header_id)
                                                        and active_flag = nvl(?, active_flag)", [$id, $activeFlag])
                                            ->orderBy('group_code', 'asc')
                                            ->get();

        return $collection;
    }

    public function updateActiveFlag($data)
    {
        $db = PtirPolicyGroupHeaders::find($data['group_header_id']);
        $db->active_flag           = $data['active_flag'];
        $db->last_updated_by       = $data['last_updated_by'];
        $db->updated_at            = Carbon::now();
        $db->last_update_date      = Carbon::now();
        $db->save();
    } 

    public static function duplicateCheck($groupCode)
    {
        $collection = PtirPolicyGroupHeaders::where('group_code', $groupCode)->first();

        if ($collection == null) 
        {
            return true;
        }

        return false;
    }

    public static function updateDesc($data)
    {
        $db = PtirPolicyGroupHeaders::find($data['group_header_id']);
        $db->group_description     = $data['group_description'];
        $db->last_updated_by       = $data['last_updated_by'];
        $db->updated_at            = Carbon::now();
        $db->last_update_date      = Carbon::now();
        $db->save(); 
    }

    public function lines()
    {
        return $this->hasMany('App\Models\IR\Settings\PtirPolicyGroupLines', 'group_header_id', 'group_header_id');
    }
}
