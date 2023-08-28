<?php

namespace App\Repositories\Interfaces;

interface PaginationInterface
{
    public function getLimit(): int;

    public function getOffset(): int;

    public function getLastId(): int;
}
