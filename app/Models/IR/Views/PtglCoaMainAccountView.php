<?php

namespace App\Models\IR\Views;

use Illuminate\Database\Eloquent\Model;

class PtglCoaMainAccountView extends Model
{
    protected $table = "ptgl_coa_main_account_v";

    private $limit = 50;

    /**
     * Get all main account
     */
    public function getMainAccount($id, $keyword)
    {
        $keyword = (isset($keyword)) ? '%'.$keyword.'%' : '%';
        $collection = PtglCoaMainAccountView::select('main_account', 'meaning', 'description')
                                            ->whereRaw("main_account = nvl(?, main_account)
                                                        and description like ? or main_account like ?
                                                        and trunc(sysdate) between trunc(nvl(start_date_active, sysdate))
                                                           and trunc(nvl(end_date_active, sysdate))
                                                        and summary_flag = 'N'", 
                                                        [$id, $keyword, $keyword]) 
                                            ->take($this->limit)
                                            ->orderBy('main_account', 'asc')
                                            ->get();

        return $collection;
    }

    public function mainAccountResult($setName, $setValue, $text)
    {
        $flexValue = self::selectRaw('main_account as flex_value, description')
            ->where('flex_value_set_name', $setName)
            // ->where('summary_flag', 'N')
            ->when($text, function ($query, $text) {
                return $query->where(function($r) use ($text) {
                    $r->where('main_account', 'like', "${text}%")
                        ->orWhere('description', 'like', "%${text}%");
                });
            })
            ->orderBy('main_account')
            ->limit(50)
            ->get();

        if ($setValue) {
            $flexAddDefault = self::selectRaw('main_account as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('main_account', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('main_account')
                ->first();

            if ($flexAddDefault) {
                $flexValue = $flexValue->push($flexAddDefault)->unique('flex_value');
            }
        }

        return $flexValue;
    }

    public function mainAccountDesc($setName, $setValue, $text)
    {
        $flexValue = null;
        if ($setValue) {
            $flexValue = self::selectRaw('main_account as flex_value, description')
                ->where('flex_value_set_name', $setName)
                ->where('main_account', $setValue)
                // ->where('summary_flag', 'N')
                ->orderBy('main_account')
                ->first();
        }
        return $flexValue;
    }

}
