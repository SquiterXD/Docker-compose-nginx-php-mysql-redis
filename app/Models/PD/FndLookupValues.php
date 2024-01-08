<?php


namespace App\Models\PD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FndLookupValues extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'APPS.FND_LOOKUP_VALUES';
    public $timestamps = false;

    protected $fillable = [
    ];

    // lookup_type
    // language
    // lookup_code
    // meaning
    // description
    // enabled_flag
    // start_date_active
    // end_date_active
    // created_by
    // creation_date
    // last_updated_by
    // last_update_login
    // last_update_date
    // source_lang
    // security_group_id
    // view_application_id
    // territory_code
    // attribute_category
    // attribute1
    // attribute2
    // attribute3
    // attribute4
    // attribute5
    // attribute6
    // attribute7
    // attribute8
    // attribute9
    // attribute10
    // attribute11
    // attribute12
    // attribute13
    // attribute14
    // attribute15
    // tag
    // leaf_node
    // zd_edition_name
    // zd_sync
}
