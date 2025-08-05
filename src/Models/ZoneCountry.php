<?php

namespace Newnet\Zone\Models;

use Illuminate\Database\Eloquent\Model;
use Newnet\Media\Traits\HasMediaTrait;

/**
 * @mixin \Eloquent
 */
class ZoneCountry extends Model
{
    use HasMediaTrait;

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
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'args' => 'object',
    ];

    public function provinces()
    {
        return $this->hasMany(ZoneProvince::class, 'country_id');
    }

    public function setImageAttribute($value)
    {
        $this->mediaAttributes['image'] = $value;
    }

    public function getImageAttribute()
    {
        return $this->getFirstMedia('image');
    }
}
