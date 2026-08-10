<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $table = 'loan_applications';

    protected $fillable = [
        'bank_id',
        'branch_id',
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
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function bank()
    {
        return $this->belongsTo(\App\Models\BasicSettings\Bank::class, 'bank_id');
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\BasicSettings\BankBranch::class, 'branch_id');
    }
}
