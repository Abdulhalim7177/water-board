<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Authenticatable
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    public function roads()
    {
        return $this->hasMany(Road::class);
    }

    public function complaints()
    {
        return $this->belongsToMany(Complaint::class, 'complaint_staff', 'staff_id', 'complaint_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'created_by');
    }
}
?>