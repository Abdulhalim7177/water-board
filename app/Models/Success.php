<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Success extends Model
{
    use HasFactory;

    protected $table = 'successes';

    protected $fillable = ['polio_id', 'name'];

    public function polio()
    {
        return $this->belongsTo(Polio::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
?>