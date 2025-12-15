<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
        'limit',
        'used',
        'target_user',   // ← thêm dòng này
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'is_active'  => 'boolean',
    ];

    public function isExpired()
    {
        return $this->end_date && $this->end_date->isPast();
    }

    public function isAvailable()
    {
        if (!$this->is_active) return false;
        if ($this->isExpired()) return false;
        if ($this->limit > 0 && $this->used >= $this->limit) return false;
        return true;
    }
}
