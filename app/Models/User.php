<?php

namespace App\Models;

use App\Models\Certificate\BirthCertificate;
use App\Models\Certificate\CharacterCertificate;
use App\Models\Certificate\CitizenCertificate;
use App\Models\Certificate\DeathCertificate;
use App\Models\People\AddressInfo;
use App\Models\People\DisabilityInfo;
use App\Models\People\EducationalInfo;
use App\Models\People\FamilyInfo;
use App\Models\People\FinancialInfo;
use App\Models\People\FreedomFighterInfo;
use App\Models\People\HealthInfo;
use App\Models\People\ProfessionalInfo;
use App\Models\People\PropertyInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public static $snakeAttributes = false;
    public $table = 'users';
    protected $fillable = [
        'system_id',
        'institute_id',
        'role_id',
        'name',
        'email',
        'mobile',
        'password',
        'status',
        'birth_certificate',
        'nid'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Generate 9-digit Approved ID in format YYMM00000
     * YY: 2-digit year of approval
     * MM: 2-digit month of approval
     * 5-digit serial number
     */
    public static function generateApprovedId()
    {
        $prefix = date('ym'); // 2 digit Year + 2 digit Month

        $latest = self::where('approved_id', 'like', $prefix . '%')
            ->orderBy('approved_id', 'desc')
            ->value('approved_id');

        if ($latest) {
            $number = (int) substr($latest, 4) + 1;
        } else {
            $number = 1;
        }

        return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->system_id = IdGenerator::generate(['table' => 'users', 'field' => 'system_id', 'length' => 11, 'prefix' => date("Ymd") ]);
        });
    }


    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id', 'id');
    }

    public function people()
    {
        return $this->hasOne(People::class, 'user_id', 'id');
    }

    public function farmer()
    {
        return $this->hasOne(Farmer::class, 'user_id', 'id');
    }

    public function familyInfo()
    {
        return $this->hasOne(FamilyInfo::class, 'user_id', 'id');
    }
    public function addressInfo()
    {
        return $this->hasOne(AddressInfo::class, 'user_id', 'id');
    }
    public function healthInfo()
    {
        return $this->hasOne(HealthInfo::class, 'user_id', 'id');
    }

    public function disabilityInfo()
    {
        return $this->hasOne(DisabilityInfo::class, 'user_id', 'id');
    }

    public function freedomFighterInfo()
    {
        return $this->hasOne(FreedomFighterInfo::class, 'user_id', 'id');
    }

    public function educationInfos()
    {
        return $this->hasMany(EducationalInfo::class, 'user_id', 'id');
    }

    public function professionalInfos()
    {
        return $this->hasMany(ProfessionalInfo::class, 'user_id', 'id');
    }

    public function financialInfos()
    {
        return $this->hasMany(FinancialInfo::class, 'user_id', 'id');
    }

    public function propertyInfos()
    {
        return $this->hasOne(PropertyInfo::class, 'user_id', 'id');
    }

    public function classificationInfo()
    {
        return $this->hasOne(ClassificationInfo::class, 'user_id', 'id');
    }

    public function loanInfos()
    {
        return $this->hasMany(LoanInfo::class, 'user_id', 'id');
    }

    public function citizenCertificate()
    {
        return $this->hasMany(CitizenCertificate::class, 'user_id', 'id');
    }

    public function characterCertificate()
    {
        return $this->hasMany(CharacterCertificate::class, 'user_id', 'id');
    }

    public function deathCertificate()
    {
        return $this->hasMany(DeathCertificate::class, 'user_id', 'id');
    }

    public function birthCertificate()
    {
        return $this->hasMany(BirthCertificate::class, 'user_id', 'id');
    }

    public function cultivations()
    {
        return $this->hasMany(CultivationInfo::class, 'user_id', 'id');
    }

    public function lands()
    {
        return $this->hasMany(LandInfo::class, 'user_id', 'id');
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function bankUser()
    {
        return $this->hasOne(BankUser::class, 'user_id', 'id');
    }
}
