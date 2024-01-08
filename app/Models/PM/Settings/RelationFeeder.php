<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationFeeder extends Model
{
    use HasFactory;

    protected $table  = 'ptpm_relation_feeder';
    protected $primaryKey = false;
    public $incrementing = false;
    public $timestamps = false;
    protected $dates = ['expired_at'];

    protected $fillable = [ 'machnie_group', 'feeder_code', 'description', 'enabled_flag', 'start_date_active',
                            'end_date_active', 'attribute1', 'attribute2', 'attribute3', 'attribute4', 
                            'attribute5', 'attribute6', 'attribute7', 'attribute8', 'attribute9', 
                            'attribute10', 'program_code', 'created_at', 'updated_at', 'deleted_at', 
                            'created_by_id', 'updated_by_id', 'deleted_by_id', 'created_by', 
                            'last_updated_by', 'creation_date', 'last_update_date'];

    public function machineGroupS () 
    {
        return $this->hasOne(MachineGroupS::class, 'lookup_code' ,'machnie_group');
    }

    public function feederName () 
    {
        return $this->hasOne(FeederName::class, 'lookup_code' ,'feeder_code');
    }
}
