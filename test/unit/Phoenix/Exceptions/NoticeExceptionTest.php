<?php
/**
 * NoticeException unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../../../Phoenix/Exceptions/NoticeException.php';
use \Phoenix\Exceptions\NoticeException;

class NoticeExceptionTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
    }
    
    public function testEnabledRegistration(){
        $this->assertTrue(NoticeException::isRegistrationEnabled());
    }
       
    public function testDisabledRegistration(){
        $this->assertFalse(NoticeException::isRegistrationEnabled());
    }
}
?>