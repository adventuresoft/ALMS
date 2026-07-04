<?php

namespace App\Models\Certificate;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DeathCertificate extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    public $table = 'death_certificates';
    protected $fillable = [
    'user_id',
    'fees',
    'quantity',
    'total_amount',
    'taken_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->system_id = IdGenerator::generate(['table' => 'death_certificates', 'field' => 'system_id', 'length' => 11, 'prefix' => date("Ymd") ]);
        });
    }
}
