<?php

namespace App\Models\Organization;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Division;
use App\Models\District;

class OrganizationBranch extends Model
{
    use HasFactory;

    public static $snakeAttributes = false;
    protected $table = "organization_branches";
    protected $fillable = [
        'name', 
        'bn_name', 
        'organization_id',
        'division_id', 
        'district_id', 
        'thana_id', 
        'union_id', 
        'address', 
        'priority', 
        'remarks', 
        'status', 
        'created_by', 
        'updated_by'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function division(){
        return $this->belongsTo(Division::class);
    }
    
    public function district(){
        return $this->belongsTo(District::class);
    }

}
