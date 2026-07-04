<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CultivationInfo extends Model
{
    use HasFactory;
    
    
    public function cropInfo(){
        return $this->hasOne(Crop::class,'id','crop');
    
    }
    
}
