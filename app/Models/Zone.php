<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'zones';

    protected $fillable = ['district_id', 'name'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function subzones()
    {
        return $this->hasMany(Subzone::class);
    }
}
?>