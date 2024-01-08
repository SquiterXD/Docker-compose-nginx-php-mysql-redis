<?php

namespace App\Models\IE;
use Illuminate\Database\Eloquent\Model;

class HierarchyTopic extends Model
{
    protected $table = 'ptw_hierarchy_topics';
    public $primaryKey = 'hierarchy_topic_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date'];
}