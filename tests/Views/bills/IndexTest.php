<?php

use App\User;

class IndexTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$user = User::all()->random();
		$this->be($user);
	}

	public function testEditBill()
	{
		$this->visit('')
			->click('Edit')
			->see('Edit:');
	}

	public function testAddNewBill()
	{
		$this->visit('')
			->click('Add New Bill')
			->see('Add a new bill');
	}

	public function testAccounts()
	{
		$this->visit('')
			->click('Accounts')
			->see('Accounts');
	}
}