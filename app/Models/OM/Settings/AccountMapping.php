<?php

namespace App\Models\OM\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountMapping extends Model
{
    use HasFactory;

    protected $table = 'ptom_mapping_account_code_gl';
    protected $primaryKey = 'account_id';

    public function scopeSearch($q, $accountCode, $status)
    {
        return $q->when($accountCode, function($q) use($accountCode) {
            $q->where('account_code', 'like', '%' . $accountCode . '%');
        })->when($status, function($q) use($status) {
            $q->where('active_flag', $status);
        });
    }

    public function getFullGlCodeAttribute()
    {
        return sprintf('%s.%s.%s.%s.%s.%s.%s.%s.%s.%s.%s.%s',
            $this->segment1,
            $this->segment2,
            $this->segment3,
            $this->segment4,
            $this->segment5,
            $this->segment6,
            $this->segment7,
            $this->segment8,
            $this->segment9,
            $this->segment10,
            $this->segment11,
            $this->segment12
        );
    }


}
