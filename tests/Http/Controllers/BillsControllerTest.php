<?php
/**
 * Created by PhpStorm.
 * User: Derek
 * Date: 11/06/2015
 * Time: 12:53 PM
 */

class BillsControllerTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testIndexRequiresLogin()
    {
        $response = $this->call('GET', 'bills');
        $this->assertTrue($response->isRedirection());
    }

    public function testIndex()
    {
        //$mocked = Mock
        $user = new App\User(['name' => 'Derek']);
        $this->be($user);
        $response = $this->call('GET', 'bills');
        $this->assertRequestOk($response);
        $this->assertViewReceives($response, 'bills');
//        $this->view
    }
}