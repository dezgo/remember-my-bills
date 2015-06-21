<?php

class BillsControllerTest extends TestCase
{
   public function testIndexRequiresLogin()
    {
        $response = $this->call('GET', 'bills');
        $this->assertTrue($response->isRedirection());
    }

    public function testIndex()
    {
        $user = new App\User(['id' => 9999, 'name' => 'Derek']);
        $user->accounts[] = new App\Account(['description' => 'Account 1']);

        $this->be($user);
        $response = $this->call('GET', 'bills');

        $this->assertRequestOk($response);
        $this->assertViewReceives($response, 'bills');
    }
}