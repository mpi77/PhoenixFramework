<?php
/**
 * FailureException unit test.
 *
 * @version 1.1
 * @author MPI
 * */
include '../../../../Phoenix/Exceptions/BaseException.php';
include '../../../../Phoenix/Exceptions/FailureException.php';

use \Phoenix\Exceptions\BaseException;
use \Phoenix\Exceptions\FailureException;
class FailureExceptionTest extends \PHPUnit_Framework_TestCase {
    private $e;

    protected function setUp() {
        $this->e = null;
    }

    public function testEnabledRegistration() {
        $this->assertTrue(FailureException::isRegistrationEnabled());
    }

    public function testSingleExceptions() {
        $this->assertTrue(FailureException::set(1, 11));
        $this->assertTrue(FailureException::set(2, 12));
        $this->assertTrue(FailureException::set(3, 13));
        $this->assertTrue(FailureException::set(4, 14));
        $this->assertTrue(FailureException::set(5, 15));
        
        $expected = array (
                        1 => 11,
                        2 => 12,
                        3 => 13,
                        4 => 14,
                        5 => 15 
        );
        $actual = FailureException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(11, FailureException::get(1));
        $this->assertSame(12, FailureException::get(2));
        $this->assertSame(13, FailureException::get(3));
        $this->assertSame(14, FailureException::get(4));
        $this->assertSame(15, FailureException::get(5));
    }

    public function testArrayExceptions() {
        $expected = array (
                        1 => 1001,
                        2 => 1002,
                        3 => 1003,
                        4 => 1004,
                        5 => 1005 
        );
        $this->assertTrue(FailureException::setArray($expected));
        
        $actual = FailureException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(1001, FailureException::get(1));
        $this->assertSame(1002, FailureException::get(2));
        $this->assertSame(1003, FailureException::get(3));
        $this->assertSame(1004, FailureException::get(4));
        $this->assertSame(1005, FailureException::get(5));
    }

    public function testGetlUndefinedKeys() {
        $this->assertNull(FailureException::get(-125));
        $this->assertNull(FailureException::get(999));
    }

    public function testGetInvalidKeys() {
        $this->assertNull(FailureException::get(0.0));
        $this->assertNull(FailureException::get(0.1));
        $this->assertNull(FailureException::get("hello"));
        $this->assertNull(FailureException::get("*-*"));
        $this->assertNull(FailureException::get(true));
        $this->assertNull(FailureException::get(null));
    }

    public function testDisableRegistration() {
        FailureException::disableRegistration();
        
        /* modify single exception */
        $this->assertFalse(FailureException::set(5, 15));
        $this->assertSame(1005, FailureException::get(5));
        
        /* modify array exceptions */
        $modify = array (
                        1 => 101,
                        2 => 102,
                        3 => 103,
                        4 => 104,
                        5 => 105 
        );
        $expected = array (
                        1 => 1001,
                        2 => 1002,
                        3 => 1003,
                        4 => 1004,
                        5 => 1005 
        );
        $this->assertFalse(FailureException::setArray($modify));
        $actual = FailureException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(1005, FailureException::get(5));
    }

    public function testDisabledRegistration() {
        $this->assertFalse(FailureException::isRegistrationEnabled());
    }

    public function testNewException() {
        $this->e = new FailureException(0);
        $this->assertSame(0, $this->e->getCode());
        
        $this->e = new FailureException(5);
        $this->assertSame(5, $this->e->getCode());
    }
}
?>