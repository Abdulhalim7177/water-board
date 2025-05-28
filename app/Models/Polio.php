<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polio extends Model
{
    use HasFactory;

    protected $table = 'polios';

    protected $fillable = ['road_id', 'name'];

    public function road()
    {
        return $this->belongsTo(Road::class);
    }

    public function successes()
    {
        return $this->hasMany(Success::class);
    }
}
?>