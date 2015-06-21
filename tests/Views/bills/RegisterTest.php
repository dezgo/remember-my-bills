<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
	use DatabaseTransactions;

	public function testRegisterShow()
	{
		$this->visit('/auth/register')
			 ->see('Confirm Password');
	}

	public function testRegisterBlank()
	{
		$this->visit('/auth/register')
			 ->press('Register')
			 ->see('Whoops!')
			 ->see('The name field is required')
			 ->see('The email field is required')
 			 ->see('The password field is required');
	}

	public function testRegister()
	{
		$name = 'Joe Bloe';
		$email = 'joe2@bloe.com';
		$password = 'password';

		$this->visit('/auth/register')
			 ->type($name, 'name')
			 ->type($email, 'email')
			 ->type($password, 'password')
			 ->type($password, 'password_confirmation')
			 ->press('Register')
			 ->seePageIs('/accounts');
	}

}