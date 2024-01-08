<?php

namespace App\Models\OM\DebitNote;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsModel extends Model
{
    use HasFactory;
    protected $table = 'ptom_terms_v';
    public $primaryKey = 'term_id';
    public $timestamps = false;
}
