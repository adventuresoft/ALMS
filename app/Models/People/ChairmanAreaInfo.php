<?php

namespace App\Models\People;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChairmanAreaInfo extends Model
{
    use HasFactory;
    public static $snakeAttributes = false;

    protected $fillable = ['user_id',
    'chairman_type_id',
    'area_info_id',
    'city_corporation',
    'union_id',
    'word_id',
    'status',
    ];
}
