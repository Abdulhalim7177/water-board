<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    public function tariffCategories()
    {
        return $this->hasMany(TariffCategory::class);
    }

    public function logs()
    {
        return $this->hasMany(AdminLog::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
    public function complaints()
    {
        return $this->belongsToMany(Complaint::class, 'complaint_admin', 'admin_id', 'complaint_id');
    }
}
?>