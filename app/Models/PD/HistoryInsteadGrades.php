<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

use App\Models\PD\MedicinalLeafItemV;
use App\Models\PD\HistoryInsteadGradesD;

class HistoryInsteadGrades extends Model
{
    use HasFactory;

    protected $table = 'PTPD_HISTORY_INSTEAD_GRADES';
    public $primaryKey = 'history_id';

    public $timestamps = false;

    public function scopeSearch($q, $search)
    {
        $medicinalLeafTypesHArr = explode(".",$search['medicinalLeafH']);
        $categoryCode1 = Arr::get($medicinalLeafTypesHArr, '0');
        $categoryDesc1 = Arr::get($medicinalLeafTypesHArr, '1');

        $medicinalLeafTypesLArr = explode(".",$search['medicinalLeafL']);
        $categoryCode2 = Arr::get($medicinalLeafTypesLArr, '0');
        $categoryDesc2 = Arr::get($medicinalLeafTypesLArr, '1');

        if ($search){
            if ($categoryCode1 != null) {
                $q->where('medicinal_leaves_type', $categoryCode1);
            }

            if ($categoryCode2 != null) {
                $q->where('medicinal_leaf_species', $categoryCode2);
            }

            if ($search['medicinalItem'] != null) {
                $q->where('medicinal_leaf_group', $search['medicinalItem']);
            }
        }

        return $q;
    }

    public function historyInsteadGradesD()
    {
        return $this->hasMany(HistoryInsteadGradesD::class, 'history_id', 'history_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($historyInsteadGrades) { 
            $historyInsteadGrades->historyInsteadGradesD()->delete();
        });
    }
}
