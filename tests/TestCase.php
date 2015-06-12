<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    protected $baseUrl = 'http://localhost';

    /**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

    public function assertRequestOk($response)
    {
        //below didn't work - client doesn't exist. got around it by passing in response
//        $response = $this->client->getResponse();
        $this->assertTrue($response->isOk());
    }

    public function assertViewReceives($response, $prop, $val = null)
    {
        $prop = $response->original->$prop;
        if ($val)
        {
            return $this->assertEquals($val, $prop);
        }
        $this->assertTrue(!! $prop);
    }
}
