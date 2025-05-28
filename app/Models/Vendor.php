<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends Authenticatable
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = ['name', 'email', 'password', 'contact'];

    protected $hidden = ['password', 'remember_token'];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payer_id')->where('payer_type', 'vendor');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
?>