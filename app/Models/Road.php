<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    use HasFactory;

    protected $table = 'roads';

    protected $fillable = ['subzone_id', 'name', 'staff_id'];

    public function subzone()
    {
        return $this->belongsTo(Subzone::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function polios()
    {
        return $this->hasMany(Polio::class);
    }
}
?>