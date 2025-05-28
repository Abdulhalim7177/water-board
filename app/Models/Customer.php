<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'customers';

    protected $fillable = [
        'billing_id', 'name', 'email', 'password', 'address', 'gps_coordinates', 'contact', 'success_id', 'status', 'created_by'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payer_id', 'billing_id')->where('payer_type', 'customer');
    }

    public function success()
    {
        return $this->belongsTo(Success::class);
    }

    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }
}
?>