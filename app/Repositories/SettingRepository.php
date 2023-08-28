<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository extends Repository
{
    public function model(): string
    {
        return Setting::class;
    }

    public function findByKey($key)
    {
        return $this->model->firstWhere('key', $key);
    }
}
