<?php

namespace Newnet\Zone\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 */
class ZoneCountry extends Model
{
    protected $table = 'zone_countries';

    protected $fillable = [
        'name',
        'code',
        'is_active',
        'alpha2',
        'alpha3',
        'numeric',
        'phone_code',
        'currency',
        'emoji_flag',
        'args',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'args' => 'object',
    ];

    public function provinces()
    {
        return $this->hasMany(ZoneProvince::class, 'country_id');
    }
}
