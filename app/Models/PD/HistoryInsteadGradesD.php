<?php

namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class HistoryInsteadGradesD extends Model
{
    use HasFactory;

    protected $table = 'ptpd_history_instead_grades_d';
    public $primaryKey = 'history_id';

    public $timestamps = false;

    public function scopeSearch($q, $search, $historyId)
    {
        $medicinalLeafTypesHArr = explode(".",$search['medicinalLeafH']);
        $categoryCode1 = Arr::get($medicinalLeafTypesHArr, '0');
        $categoryDesc1 = Arr::get($medicinalLeafTypesHArr, '1');

        $medicinalLeafTypesLArr = explode(".",$search['medicinalLeafL']);
        $categoryCode2 = Arr::get($medicinalLeafTypesLArr, '0');
        $categoryDesc2 = Arr::get($medicinalLeafTypesLArr, '1');

        if ($search){
            if ($categoryCode1 != null) {
                $q->where('history_id', $historyId);
            }
        }

        return $q;
    }
}
