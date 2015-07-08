<?php
/**
 * Created by PhpStorm.
 * User: Derek
 * Date: 8/07/2015
 * Time: 3:01 PM
 */

use Illuminate\Foundation\Testing\DatabaseTransactions;

class LeagueCSVTest extends TestCase
{
    use DatabaseTransactions;

    public function testReadCSV(App\Contracts\CSVReader $reader)
    {
        // not sure how to test this without passing an actual file
        // nothing to mock as filename is passed to class :(
        //$reader->open();
    }
}