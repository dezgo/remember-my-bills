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

    public function testHasManyBills()
    {
        $this->assertHasMany('bills', 'App\Account');
    }
}