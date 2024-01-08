<?php

namespace App\Models\EAM\LOV;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ItemNonstock extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_item_nonstock_v";

    private $limit = 20;

    public function Search($request)
    {   
        $limit = $request->p_limit ?? $this->limit;
        $query = $this;
        $query = $this->scopeSearch($query,$request);

        $result = $query->paginate($limit);
        
        return response()->json($result);

    }

    public function scopeSearch($q, $search)
    {
        $mapColumns = ['item_code','item_description','part_number','old_item_number','part_number_old','machine_01','machine_02'];
        foreach ($search as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    $q = $q->whereRaw(" lower({$key}) like '{$value}' ");
                }
            }
        }

        return $q;
    }

}
