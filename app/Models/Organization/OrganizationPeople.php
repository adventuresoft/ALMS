<?php

namespace App\Models\Organization;


use App\Models\BasicSettings\Village;
use App\Models\House;
use App\Models\Institute;
use App\Models\Road;
use App\Models\People;
use App\Models\VillageArea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class OrganizationPeople extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    
    protected $fillable = [
        
        'organization_id', 
        'people_id',    
        'branch_id',    
        'status'
    ];

    
     /**
     * Bank linked with this user
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization\Organization::class, 'organization_id');
    }
        public function branch()
        {
            return $this->belongsTo(\App\Models\Organization\OrganizationBranch::class, 'branch_id');
        }

    /**
     * Person record
     */
    public function person()
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    public function userinfo()
    {
        return $this->belongsTo(\App\Models\User::class, 'people_id');
    }

    /**
     * Direct access to Laravel User
     * (through the People model)
     */
    public function user()
    {
        return $this->hasOneThrough(
            \App\Models\User::class,
            \App\Models\People::class,
            'id',        // people.id
            'id',        // users.id
            'people_id', // bank_users.people_id
            'user_id'    // people.user_id
        );
    }


}
