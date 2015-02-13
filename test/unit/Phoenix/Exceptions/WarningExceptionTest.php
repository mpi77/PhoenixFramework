<?php
/**
 * WarningException unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../../../Phoenix/Exceptions/WarningException.php';
use \Phoenix\Exceptions\WarningException;

class WarningExceptionTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
    }
    
    public function testEnabledRegistration(){
        $this->assertTrue(WarningException::isRegistrationEnabled());
    }
       
    public function testDisabledRegistration(){
        $this->assertFalse(WarningException::isRegistrationEnabled());
    }
}
?>