<?php


namespace App\Models\PM\Lookup;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PtpmMatInternalStatusLookup extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'OAPM.PTPM_MAT_INTERNAL_STATUS';
    public $timestamps = false;

    protected $fillable = [
        'lookup_code',
        'meaning',
        'description',
        'tag',
        'start_date_active',
        'end_date_active',
        'enabled_flag',
        'attribute_category',
        'attribute1',
        'attribute2',
        'attribute3',
        'attribute4',
        'attribute5',
        'attribute6',
        'attribute7',
        'attribute8',
        'attribute9',
        'attribute10',
        'attribute11',
        'attribute12',
        'attribute13',
        'attribute14',
        'attribute15',
    ];
}
