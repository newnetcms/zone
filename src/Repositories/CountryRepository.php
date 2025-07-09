<?php

namespace Newnet\Zone\Repositories;

use Newnet\Core\Repositories\BaseRepository;
use Newnet\Zone\Models\ZoneCountry;

class CountryRepository extends BaseRepository
{
    public function __construct(ZoneCountry $model)
    {
        parent::__construct($model);
    }

    protected function builder()
    {
        $builder = $this->model->newQuery();

        if ($name = request('name')) {
            $builder->where('name', 'like', "%$name%");
        }

        return $builder->orderBy('name');
    }
}
