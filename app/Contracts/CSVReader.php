<?php

namespace App\Contracts;

interface CSVReader
{
	public function open($filename);

	public function readAll();
}