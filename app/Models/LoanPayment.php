<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{
    use HasFactory;

    public function loanInfo()
    {
        return $this->belongsTo(LoanInfo::class, 'loan_info_id', 'id');
    }
}
