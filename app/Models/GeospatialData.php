<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeospatialData extends Model
{
    protected $fillable = ['customer_id', 'type', 'coordinates'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
?>