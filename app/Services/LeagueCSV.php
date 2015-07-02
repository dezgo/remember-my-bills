<?php

namespace App\Services;

use App\Contracts\CSV;
use League\Csv\Reader;
use App\Bill;
use Illuminate\Support\Facades\Auth;

class LeagueCSV implements CSVReader
{

	protected $file;

	/**
	 * Set file to read
	 *
	 * @param $filename
	 * @return $this
	 */
	public function open($filename)
	{
		$this->file = Reader::createFromPath($filename);
		return $this;
	}

	/**
	 * Read all data in the CSV and return as array
	 *
	 * @return mixed
	 */
	public function readAll()
	{
		return $this->file->fetchAll();
	}
}