<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'action', 'details'];

    // เชื่อมกับ Admin (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
