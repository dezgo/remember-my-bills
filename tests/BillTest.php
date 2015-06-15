<?php

use App\Bill;
use Way\Tests\Factory;
use Carbon\Carbon;

/**
 * Class BillTest
 */
class BillTest extends TestCase {
	use Way\Tests\ModelHelpers;

	/**
	 * Test the Bill eloquent model class
	 *
	 * @return void
	 */

	private $bill;

	/**
	 * Setup by creating a new bill
	 */
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

	/**
	 * Check monthly attribute
	 */
	public function testMonthlyAttribute()
	{
		$this->bill->times_per_year = 4;
		$this->bill->amount = 234;

		$expect = 234/3;
		$actual = $this->bill->monthly;

		$this->assertEquals($expect, $actual);
	}

	/**
	 * check InDays attribute
	 */
	public function testInDaysAttribute()
	{
		$this->bill->last_due = Carbon::now();
		$this->bill->times_per_year = 365;

		$expect = '1 day from now';
		$actual = $this->bill->inDays;

		$this->assertEquals($expect, $actual);
	}

	/**
	 * Ensure belongsToUser relationship OK
	 */
	public function testBelongsToUser()
	{
		$this->assertBelongsTo('user', 'App\Bill');
	}

	/**
	 * Ensure belongsToAccount relationship OK
	 */
	public function testBelongsToAccount()
    {
        $this->assertBelongsTo('account', 'App\Bill');
    }

	/**
	 * When paying a daily bill, next due should be tomorrow
	 */
	public function testPay365()
	{
		$this->bill->last_due = Carbon::now();
		$this->bill->times_per_year = 365;
		$this->bill->pay();

		$expect = Carbon::now()->addDay();
		$actual = $this->bill->last_due;

		$this->assertEquals($expect, $actual);
	}

	/**
	 * When paying a bill before the due date, ensure it still
	 * advances to the next due date
	 */
	public function testPay12()
	{
		$date = Carbon::create(2015,5,20);
		$this->bill->last_due = $date;
		$this->bill->times_per_year = 12;
		$this->bill->pay(Carbon::now()->subDays(3));

		$expect = $date->addDays(365/12);
		$actual = $this->bill->last_due;

		$this->assertEquals($expect, $actual);
	}
}
