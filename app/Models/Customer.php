<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'customers';


    protected $hidden = ['password', 'remember_token'];


    use HasApiTokens;

    protected $fillable = [
        'billing_id', 'delivery_code', 'household_id', 'first_name', 'surname', 'middle_name',
        'email', 'password', 'street_name', 'area', 'landmark', 'lga_code', 'ward_code',
        'gps_coordinates', 'contact', 'billing_condition', 'customer_position',
        'water_supply_status', 'success_id', 'status'
    ];

    public static function generateBillingId()
    {
        $year = date('y'); // e.g., 25
        $month = date('m'); // e.g., 05
        $serial = str_pad(self::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count() + 1, 4, '0', STR_PAD_LEFT); // e.g., 0001
        return $year . $month . $serial; // e.g., 25050001
    }

    public function success()
    {
        return $this->belongsTo(Success::class);
    }

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }

    public function geospatialData()
    {
        return $this->hasMany(GeospatialData::class);
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'payer_id', 'billing_id')->where('payer_type', 'customer');
    }

    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }
}
?>