<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';

    protected $fillable = ['customer_id', 'description', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'complaint_admin', 'complaint_id', 'admin_id');
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'complaint_staff', 'complaint_id', 'staff_id');
    }
}
?>