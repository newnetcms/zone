<?php

namespace Newnet\Zone\Traits;

use Newnet\Zone\Models\ZoneDistrict;
use Newnet\Zone\Models\ZoneProvince;
use Newnet\Zone\Models\ZoneTownship;

trait ZoneTrait
{
    public function province()
    {
        return $this->belongsTo(ZoneProvince::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(ZoneDistrict::class, 'district_id');
    }

    public function township()
    {
        return $this->belongsTo(ZoneTownship::class, 'township_id');
    }

    public function getFullAddressAttribute($value)
    {
        $address = [
            $this->address,
            object_get($this, 'township.name'),
            object_get($this, 'district.name'),
            object_get($this, 'province.name'),
        ];

        return implode(', ', array_filter($address));
    }
}
