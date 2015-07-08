<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;

class StdCSVParserTest extends TestCase
{
	use DatabaseTransactions;

	public function testCreateBills()
	{
		$user = factory('App\User')->create();
		$user->save();
		$this->be($user);

		$parser = app('App\Contracts\CSVParser');

		$csv = [
			//['id','description', 'amount'],
			[0,'iiNet', Carbon\Carbon::now(), 4, 1, false, 32.23],
			[2,'HCF', Carbon\Carbon::now(), 12, 1, false, 253],
		];

		$bills = $parser->createBills($csv);

		$expected = 2;
		$actual = count($bills);
		$this->assertEquals($expected, $actual);
		dd($user->bills());

		foreach($bills as $bill)
		{
			$user->bills()->create($bill);
		}
	}
}