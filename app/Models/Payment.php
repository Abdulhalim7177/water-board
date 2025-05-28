<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = ['tariff_id', 'payer_id', 'payer_type', 'amount', 'date', 'method'];

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    public function payer()
    {
        return $this->morphTo(__FUNCTION__, 'payer_type', 'payer_id');
    }
}
?>