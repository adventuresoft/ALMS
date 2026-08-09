<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankUser extends Model
{
    protected $table = 'bank_users';

    protected $fillable = [
        'bank_id',
        'people_id',
        'branch_id',
        'status',
    ];

    /**
     * Bank linked with this user
     */
    public function bank()
    {
        return $this->belongsTo(\App\Models\BasicSettings\Bank::class, 'bank_id');
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\BasicSettings\BankBranch::class, 'branch_id');
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