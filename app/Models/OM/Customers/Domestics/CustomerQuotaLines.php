<?php

namespace App\Models\OM\Customers\Domestics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerQuotaLines extends Model
{
    use HasFactory;

    protected $table = "PTOM_CUSTOMER_QUOTA_LINES";
    public $primaryKey = 'QUOTA_LINE_ID';
    public $timestamps = false;
    // protected $dates = ['CREATED_BY', 'LAST_UPDATE_DATE'];

    protected $fillable = [
        'QUOTA_LINE_ID',
        'QUOTA_HEADER_ID',
        'ITEM_ID',
        'ITEM_CODE',
        'ITEM_DESCRIPTION',
        'RECEIVED_QUOTA',
        'MINIMUM_QUOTA',
        'REMAINING_QUOTA',
        'PROGRAM_CODE',
        'CREATED_BY',
        'CREATION_DATE',
        'LAST_UPDATED_BY',
        'LAST_UPDATE_DATE',
        'CREATED_AT',
        'UPDATED_AT',
        'DELETED_AT',
        'CREATED_BY_ID',
        'UPDATED_BY_ID',
        'DELETED_BY_ID',
        'WEB_BATCH_NO',
        'INTERFACED_MSG',
        'INTERFACE_STATUS',
    ];
}
