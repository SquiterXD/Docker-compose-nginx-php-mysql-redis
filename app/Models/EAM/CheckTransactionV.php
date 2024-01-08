<?php

namespace App\Models\EAM;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class CheckTransactionV extends Model
{
    use HasFactory, Notifiable;

    protected $table = "pteam_check_transaction_v";
    public $primaryKey = 'item_code';
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
        $mapColumns = ['transfer_date','transfer_department'];
        foreach ($search as $key => $value) {
            $value = strtolower(trim($value));
            if ($value) {
                if (in_array($key, $mapColumns)) {
                    if ($key == 'transfer_date') {
                        $date = parseFromDateTh($value);
                        $q = $q->whereRaw(" {$key} = to_char(to_date('{$date}','yyyy-mm-dd'),'dd/mm/yyyy') ");
                    } else {
                        $q = $q->whereRaw(" lower({$key}) like '{$value}' ");
                    }
                }
            }
        }
        $q = $q->leftJoin('pteam_departments_v', 'pteam_check_transaction_v.transfer_department', '=', 'pteam_departments_v.department_code')
        ->select('pteam_check_transaction_v.*', 'pteam_departments_v.description as transfer_department_desc');
        return $q;
    }

    public function getTransferDateAttribute($value)
    {
        return parseToDateTh($value);
    }    

}
