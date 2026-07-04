<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationInfo extends Model
{
    use HasFactory;

    protected $table = "classification_infos";
    protected $fillable = [
        'user_id',
        'is_agriculture_card',
        'comments'
    ];
}
