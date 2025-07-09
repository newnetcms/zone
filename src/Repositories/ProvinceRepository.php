<?php

namespace Newnet\Zone\Repositories;

use Newnet\Core\Repositories\BaseRepository;
use Newnet\Zone\Models\ZoneProvince;

class ProvinceRepository extends BaseRepository
{
    public function __construct(ZoneProvince $model)
    {
        parent::__construct($model);
    }

    protected function builder()
    {
        $builder = $this->model->newQuery();

        if ($name = request('name')) {
            $builder->where('name', 'like', "%$name%");
        }

        return $builder->orderByRaw('sort_order IS NULL')
            ->orderBy('sort_order')
            ->orderBy('name');
    }
}
