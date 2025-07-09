<?php

namespace Newnet\Zone\Repositories;

use Newnet\Core\Repositories\BaseRepository;
use Newnet\Zone\Models\ZoneDistrict;

class DistrictRepository extends BaseRepository
{
    public function __construct(ZoneDistrict $model)
    {
        parent::__construct($model);
    }

    protected function builder()
    {
        $builder = $this->model->newQuery();

        if ($name = request('name')) {
            $builder->where('name', 'like', "%$name%");
        }

        if ($provinceId = request('province_id')) {
            $builder->where('province_id', $provinceId);
        }

        return $builder->orderByRaw('sort_order IS NULL')
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}
