<?php

namespace App\Models\IE;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;
    protected $table = 'ptw_attachments';
    public $primaryKey = 'attachment_id';
    public $timestamps = false;
    protected $dates = ['creation_date', 'last_update_date', 'deleted_at'];

    public function attachmentable()
    {
        return $this->morphTo();
    }

    public function getIsImageAttribute()
    {
        $arr_mime_pic = ["jpeg","jpg","bmp","png"];
        if (in_array(strtolower($this->mime_type), $arr_mime_pic)) {
            return true;
        } else {
            return false;
        }
    }
}
