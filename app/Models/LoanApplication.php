<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $table = 'loan_applications';

    protected $fillable = [
        'financial_year',
        'loan_amount',
        'g_name',
        'g_nid',
        'g_mobile',
        'g_father',
        'g_mother',
        'g_profession',
        'g_dob',
        'g_relation',
        'g_address',
        'created_by',
    ];
    
     public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
