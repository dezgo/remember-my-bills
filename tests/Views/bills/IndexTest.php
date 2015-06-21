<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class IndexTest - test all functions of main bills page
 */
class IndexTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * Basic setup for tests
	 */
	public function setUp()
	{
		parent::setUp();
		$user = User::all()->random();
		$this->be($user);
	}

	/**
	 * When you click to edit a bill, you should see the edit page
	 */
	public function testEditBill()
	{
		$this->visit('')
			->click('Edit')
			->see('Edit:');
	}

	/**
	 * When you click on a new bill, you should see the new bill page
	 */
	public function testAddNewBill()
	{
		$this->visit('')
			->click('Add New Bill')
			->see('Add a new bill');
	}

	/**
	 * When you click on accounts you should see the accounts page
	 */
	public function testAccounts()
	{
		$this->visit('')
			->click('Accounts')
			->see('Accounts');
	}

	/**
	 * When you click on the pay link, take the user to a pay screen
	 */
	public function testPay()
	{
		$this->visit('')
			->click('Pay')
			->see('Pay: ');
	}

	/**
	 * When there are no bills, index page should show alert
	 */
	public function testNoBillsSomeAccounts()
	{
		$user = new App\User([
			'id' => 9999,
			'name' => 'Tester',
			'email' => 'tester@gmail.com',
			'password' => bcrypt('password'),
		]);
		$user->accounts[] = new App\Account([
			'description' => 'Account1',
		]);
		$this->be($user);
		$this->visit('')
			->see('Looks like you haven\'t added any bills yet');
	}
}