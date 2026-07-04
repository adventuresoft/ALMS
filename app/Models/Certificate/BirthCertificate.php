<?php

namespace App\Models\Certificate;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthCertificate extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    public $table = 'birth_certificates';
    protected $fillable = ['user_id',
    'fees',
    'quantity',
    'total_amount',
    'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
