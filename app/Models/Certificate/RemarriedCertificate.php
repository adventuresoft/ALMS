<?php

namespace App\Models\Certificate;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RemarriedCertificate extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    public $table = 'remarried_certificates';
    protected $fillable = [
    'system_id',
    'user_id',
    'fees',
    'quantity',
    'total_amount',
    'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->system_id = IdGenerator::generate(['table' => 'remarried_certificates', 'field' => 'system_id', 'length' => 11, 'prefix' => date("Ymd") ]);
        });
    }
}
