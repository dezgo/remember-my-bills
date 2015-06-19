<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class PaymentTest
 */
class PaymentTest extends TestCase
{
    use DatabaseTransactions;
    use Way\Tests\ModelHelpers;

    private $payment;

    /**
     * Setup by creating a new bill
     */
    public function setUp()
    {
        parent::setUp();
        $this->payment = factory('App\Payment')->make([
            'user_id' => 1,
            'account_id' => 1,
        ]);
    }

    /**
     * Test we can get a payment
     */
    public function testLoad()
    {
        $expected = 1;
        $actual = $this->payment->user_id;

        $this->assertEquals($expected, $actual);
    }

    /**
     * Ensure belongsToUser relationship OK
     */
    public function testBelongsToUser()
    {
        $this->assertBelongsTo('user', 'App\Payment');
    }

    /**
     * Ensure belongsToUser relationship OK
     */
    public function testBelongsToAccount()
    {
        $this->assertBelongsTo('account', 'App\Payment');
    }

    public function testMock()
    {
        $user = Mockery::mock(['getFullName' => 'Derek Gillett']);
        $expected = 'Derek Gillett';
        $actual = $user->getFullName();

        $this->assertEquals($expected, $actual);
    }
}