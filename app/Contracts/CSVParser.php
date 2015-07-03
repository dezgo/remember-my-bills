<?php

namespace App\Contracts;

interface CSVParser
{
	public function validate($csv);

	public function createBills($csv);
}