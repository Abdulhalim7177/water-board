<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $fillable = ['admin_id', 'action', 'details'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
?>