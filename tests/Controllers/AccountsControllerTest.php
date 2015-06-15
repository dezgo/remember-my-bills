<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccountsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndexRequiresLogin()
    {
        $response = $this->call('GET', 'accounts');
        $this->assertTrue($response->isRedirection());
    }

    public function testIndex()
    {
        $user = new App\User(['name' => 'Derek']);
        $this->be($user);
        $response = $this->call('GET', 'accounts');
        $this->assertRequestOk($response);
        $this->assertViewReceives($response, 'accounts');
    }

    public function testLifecycle()
    {
        // login
        $user = new App\User(['name' => 'Derek']);
        $this->be($user);

        // create a new account
        $this->visit('/accounts/create')
            ->see('Add a new account');

//        Account::shouldReceive('post')
//            ->once()
//            ->with()
        $this->type('A new account', 'description')
            ->press('Add Account')
            ->seePageIs('/accounts');

    }
}
