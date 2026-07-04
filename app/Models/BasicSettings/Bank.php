<?php

namespace App\Models\BasicSettings;

use App\Models\BankSelling;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $table = "banks";
    protected $fillable = ['en_name', 'bn_name', 'created_by', 'updated_by'];
}
