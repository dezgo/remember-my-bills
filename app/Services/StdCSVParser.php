<?php

namespace App\Services;

use App\Contracts\CSVParser;
use App\Bill;
use Illuminate\Support\Facades\Auth;


class StdCSVParser implements CSVParser
{
//	protected $userID;
//
//	public function __construct($userID)
//	{
//		$this->userID = $userID;
//	}

	public function validate($csv)
	{
		// TODO: Implement validate() method.
	}

	/**
	 * Create an array of bills from the raw data
	 *
	 * @param $csv
	 * @return array
	 */
	public function createBills($csv)
	{
		$bills = [];

		foreach($csv as $row)
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