<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subzone extends Model
{
    use HasFactory;

    protected $table = 'subzones';

    protected $fillable = ['zone_id', 'name'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function roads()
    {
        return $this->hasMany(Road::class);
    }
}
?>