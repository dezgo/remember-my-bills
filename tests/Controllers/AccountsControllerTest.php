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
        $user = App\User::all()->first();
        $this->be($user);

        // go to account creation page
        $this->visit('/accounts/create')
            ->see('Add a new account');

        // create a new account but leave off description, validation error
        $this->type('', 'description')
            ->press('Add Account')
            ->seePageIs('/accounts/create')
            ->see('The description field is required.');

        // create a new account
        $this->type('A new account', 'description')
            ->press('Add Account')
            ->seePageIs('/accounts');

        // back on accounts page, click edit
        $this->click('Edit')
            ->see('Edit: ');

        // now update data and save
        $this->type('changed account', 'description')
            ->press('Update Account')
            ->seePageIs('/accounts');

        // back on accounts page, click edit again (to delete)
        $this->click('Edit')
            ->see('Edit: ')
            ->press('Click to permanently delete this account')
            ->seePageIs('/accounts');

    }
}
