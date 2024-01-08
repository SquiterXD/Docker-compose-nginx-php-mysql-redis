<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;

class TransactionSequence extends Model
{
	protected $table = 'ptw_transaction_sequences';
	public $primaryKey = 'transaction_sequence_id';
	protected $fillable = ['org_id', 'name', 'year', 'last_updated_by', 'created_by'];
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];

    public static function getTranID($orgId, $name, $prefix)
	{ 
        // year format date('y') ex. 16,17
    	// $last_seq = self::where('name',$name)->first();

		$user_id = \Auth::user()->user_id;
		$last_seq = self::where('org_id', $orgId)->where('name', $name)->where('year', $prefix)->first();
		if(!$last_seq){
			$last_seq = self::create(['org_id'=> $orgId,'name' => $name,'year' => $prefix,'last_updated_by' => $user_id, 'created_by' => $user_id]);
		}
        $new_tran_id = (int)$last_seq->tran_id+1;
		$last_seq->tran_id = $new_tran_id;
		$last_seq->last_updated_by = $user_id;
    	$last_seq->save();

    	return $new_tran_id;
    }

}
