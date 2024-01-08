<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class CheckOnHandV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_check_on_hand_v";
    public $primaryKey = 'item_id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];
  

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
        $mapColumns = ['item_code','item_description','part_number','old_item_number','part_number_old','machine_01','machine_02','subinventory','locator_name'];
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
