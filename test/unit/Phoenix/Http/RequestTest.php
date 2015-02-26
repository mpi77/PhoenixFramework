<?php
/**
 * Request unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../../../Phoenix/Http/Url.php';
include '../../../../Phoenix/Http/Request.php';

use \Phoenix\Http\Url;
use \Phoenix\Http\Request;
class RequestTest extends \PHPUnit_Framework_TestCase {
    private $request;

    protected function setUp() {
        $this->request = null;
    }

    public function testEmptyUrl() {
    }
}
?>