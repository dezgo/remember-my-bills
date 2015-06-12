<?php

namespace App\Repositories;

interface BillRepositoryInterface
{
    public function all();
    public function sortBy($field);
}