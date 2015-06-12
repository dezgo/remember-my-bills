<?php

use App\Account;

class AccountTest extends TestCase
{
    use Way\Tests\ModelHelpers;

    private $account;

    public function setUp()
    {
        parent::setUp();
        $this->account = new Account();
    }

    public function testBelongsToUser()
    {
        $this->assertBelongsTo('user', 'App\Account');
    }

//    public function testGetSelectData()
//    {
//        Auth::shouldReceive('user')->andReturn($user = Mockery::mock('App\User'));
//        $user->shouldReceive('accounts')->once()->andReturn($user->hasMany('App\Account'));
//        $accounts = Account::getSelectData();
//
//        $this->assertNotEmpty($accounts);
//    }
    public function test(){
        
    }
}