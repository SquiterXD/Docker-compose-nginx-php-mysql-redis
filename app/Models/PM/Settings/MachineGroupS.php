<?php

namespace App\Models\PM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineGroupS extends Model
{
    use HasFactory;

    protected $table  = 'PTPM_MACHINE_GROUPS';
    protected $primaryKey = 'lookup_code';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['lookup_code', 'meaning', 'description', 'tag', 'start_date_active', 'end_date_active', 'enabled_flag'];

    public function relationFeeder()
    {
        return $this->hasMany(RelationFeeder::class,'machnie_group' ,'lookup_code');
    }
}
