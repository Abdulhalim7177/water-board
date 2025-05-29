<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;

    protected $table = 'tariffs';

     protected $fillable = [
        'customer_id', 'tariff_category_id', 'amount', 'balance',
        'usage_rate', 'due_date', 'status'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function tariffCategory()
    {
        return $this->belongsTo(TariffCategory::class);
    }
}
?>