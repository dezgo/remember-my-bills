<?php

use App\Bill;
use Way\Tests\Factory;
use Carbon\Carbon;

class BillTest extends TestCase {
	use Way\Tests\ModelHelpers;

	/**
	 * Test the Bill eloquent model class
	 *
	 * @return void
	 */

	private $bill;

	public function setUp()
	{
		parent::setUp();
		$this->bill = new Bill;
	}

	/**
	 * Test the next due attribute
	 */
	public function testNextDueAttribute()
	{
		$last_due = Carbon::now()->subDays(20);
		$this->bill->last_due = $last_due;
		$this->bill->times_per_year = 12;

		$expect = $last_due->addDays(365/12);
		$actual = $this->bill->next_due;

		$this->assertEquals($expect, $actual);
	}

	public function testMonthlyAttribute()
	{
		$this->bill->times_per_year = 4;
		$this->bill->amount = 234;

		$expect = 234/3;
		$actual = $this->bill->monthly;

		$this->assertEquals($expect, $actual);
	}

	public function testInDaysAttribute()
	{
		$this->bill->last_due = Carbon::now();
		$this->bill->times_per_year = 365;

		$expect = '1 day from now';
		$actual = $this->bill->inDays;

		$this->assertEquals($expect, $actual);
	}

	public function testBelongsToUser()
	{
		$this->assertBelongsTo('user', 'App\Bill');
	}

    public function testBelongsToAccount()
    {
        $this->assertBelongsTo('account', 'App\Bill');
    }


}
