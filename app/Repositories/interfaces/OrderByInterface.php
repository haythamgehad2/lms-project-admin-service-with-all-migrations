<?php

namespace App\Repositories\Interfaces;

interface OrderByInterface
{
    public function getColumn(): string;

    public function getDirection(): string;
}
