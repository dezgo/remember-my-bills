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
        $user = new App\User(['name' => 'Derek']);
        $this->be($user);
        $response = $this->call('GET', 'bills');
        $this->assertRequestOk($response);
        $this->assertViewReceives($response, 'bills');
    }
}