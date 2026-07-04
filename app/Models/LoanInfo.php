<?php

namespace App\Models;

use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanInfo extends Model
{
    use HasFactory;

    public function branch()
    {
        return $this->belongsTo(BankBranch::class, 'branch_id', 'id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(LoanPayment::class, 'loan_info_id', 'id');
    }
}
