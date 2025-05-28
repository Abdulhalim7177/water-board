<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffCategory extends Model
{
    use HasFactory;

    protected $table = 'tariff_categories';

    protected $fillable = ['class', 'category', 'price', 'admin_id'];

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
?>