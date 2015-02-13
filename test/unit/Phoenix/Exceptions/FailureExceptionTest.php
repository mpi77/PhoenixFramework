<?php
/**
 * FailureException unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../../../Phoenix/Exceptions/FailureException.php';
use \Phoenix\Exceptions\FailureException;

class FailureExceptionTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
    }
    
    public function testEnabledRegistration(){
        $this->assertTrue(FailureException::isRegistrationEnabled());
    }
       
    public function testDisabledRegistration(){
        $this->assertFalse(FailureException::isRegistrationEnabled());
    }
}
?>