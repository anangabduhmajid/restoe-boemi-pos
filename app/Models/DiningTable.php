<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DiningTable extends Model
{
    protected $fillable = [
        'table_number',
        'name',
        'capacity',
        'status',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (DiningTable $table) {
            if (empty($table->qr_token)) {
                $table->qr_token = (string) Str::uuid();
            }
        });
    }
}
