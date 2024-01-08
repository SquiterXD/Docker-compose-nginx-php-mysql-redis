<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PMPlanHeaderV extends Model
{

    protected $table = "pteam_pm_plan_header_v";
    public $primaryKey = 'plan_id';
    public $timestamps = false;
    protected $dates = [
        'creation_date',
        'last_update_date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_updated_by',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    static public function listVersion($year)
    {
        $data = self::select('version_plan', 'status_plan', 'old_version_plan')
            ->where('year_plan', $year)
            ->orderBy('version_plan')
            ->get();

        return $data;
    }

    static public function getData($year, $version)
    {
        $data = self::where('year_plan', $year)
            ->where('version_plan', $version)
            ->first();

        return $data;
    }
}
