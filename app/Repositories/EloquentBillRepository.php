<?php

/**
 * Created by PhpStorm.
 * User: Derek
 * Date: 12/06/2015
 * Time: 11:51 AM
 */

namespace App\Repositories;

use \App\Bill;

class EloquentBillRepository implements BillRepositoryInterface
{

    public function all()
    {
        return Auth::user()->bills();
    }

    public function sortBy($field)
    {
        return Bill::sortBy($field);
    }
}