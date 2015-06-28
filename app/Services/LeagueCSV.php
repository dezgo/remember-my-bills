<?php

namespace App\Services;

use App\Contracts\CSV;
use League\Csv\Reader;
use App\Bill;
use Illuminate\Support\Facades\Auth;

class LeagueCSV implements CSV
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
	 * Read all data in the CSV and return as array of Bills
	 *
	 * @return mixed
	 */
	public function readAll()
	{
		return $this->file->fetchAll();
	}

	/**
	 * Create an array of bills from the raw data
	 *
	 * @return array
	 */
	private function create_bills()
	{
		$bills = [];

		foreach($this->content_raw as $row)
		{
			$new = new Bill;
			$new->user_id = Auth::user()->id;
			$new->id = $row[0] > 0 ? $row[0] : 0;
			$new->description = $row[1];
			$new->last_due = $row[2];
			$new->times_per_year = $row[3];
			$new->account_id = $row[4];
			$new->dd = $row[5];
			$new->amount = $row[6];

			$bills[] = $new;
			// issue here, we need the account id, not the account description
			// but ideally the user would upload the description
			// have to work out how to get ID from description
		}

		return $bills;
	}
}