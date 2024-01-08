<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PtglCoaSubAccountView extends Model
{
    protected $table = "ptgl_coa_sub_account_v";

    private $limit = 50;

    /**
     * Get all sub account
     */
    public function getSubAccount($id, $keyword, $mainAccount)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaSubAccountView::select(DB::raw('distinct(sub_account)'), 'meaning', 'description')
                                            ->whereRaw("sub_account = nvl(?, sub_account)
                                                        and (description like ? or sub_account like ?)
                                                        and main_account = ?
                                                        and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                        and summary_flag = 'N'",
                                                        [$id, $keyword, $keyword, $mainAccount]) 
                                            ->take($this->limit)
                                            ->orderBy('sub_account', 'asc')
                                            ->get();

        return $collection;
    }

    public function subAccountResult($setName, $setValue, $text, $setParent)
    {
        $flexValue = self::selectRaw('sub_account as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->where('main_account', $setParent)
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('sub_account', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('sub_account')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('sub_account as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('sub_account', $setValue)
                // ->where('summary_flag', 'N')
                ->where('main_account', $setParent)
                ->orderBy('sub_account')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function subAccountDesc($setName, $setValue, $text, $setParent)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('sub_account as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('sub_account', $setValue)
                // ->where('summary_flag', 'N')
                ->where('main_account', $setParent)
                ->orderBy('sub_account')
                ->first();
        }
        return $flexValue;
    }

}
