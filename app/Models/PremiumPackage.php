<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PremiumPackage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'premium_packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tag',
        'tags_json',
        'description',
        'price',
        'upi_id',
        'upi_name',
        'qr_code',
        'payment_info',
        'button_color',
        'duration_days',
        'features',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'features' => 'array',
        'tags_json' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];
}
