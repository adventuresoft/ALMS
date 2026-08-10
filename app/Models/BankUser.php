<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankUser extends Model
{
    protected $table = 'bank_users';

    protected $fillable = [
        'bank_id',
        'people_id',
        'user_id',
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
        return $this->belongsTo(\App\Models\User::class, 'user_id')->withDefault(function() {
            return $this->belongsTo(\App\Models\User::class, 'people_id')->first();
        });
    }

    /**
     * Direct access to Laravel User
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}