<?php

namespace App\Contracts;

interface CSV
{
	public function open($filename);

	public function readAll();
}