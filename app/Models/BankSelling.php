<?php

namespace App\Models;

use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\BankBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSelling extends Model
{
    use HasFactory;
    protected $table = "bank_sellings";
    protected $fillable = ['financial_year', 'bank_id',  'amount', 'created_by'];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
}
