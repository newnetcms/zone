<?php

namespace Newnet\Zone\Repositories;

use Newnet\Core\Repositories\BaseRepository;
use Newnet\Zone\Models\ZoneTownship;

class TownshipRepository extends BaseRepository
{
    public function __construct(ZoneTownship $model)
    {
        parent::__construct($model);
    }

    protected function builder()
    {
        $builder = $this->model->newQuery();

        if ($name = request('name')) {
            $builder->where('name', 'like', "%$name%");
        }

        if ($district_id = request('district_id')) {
            $builder->where('district_id', $district_id);
        }

        return $builder->orderBy('name');
    }
}
