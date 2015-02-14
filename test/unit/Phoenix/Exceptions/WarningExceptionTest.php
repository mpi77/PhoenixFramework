<?php
/**
 * WarningException unit test.
 *
 * @version 1.1
 * @author MPI
 * */
include '../../../../Phoenix/Exceptions/BaseException.php';
include '../../../../Phoenix/Exceptions/WarningException.php';

use \Phoenix\Exceptions\BaseException;
use \Phoenix\Exceptions\WarningException;
class WarningExceptionTest extends \PHPUnit_Framework_TestCase {
    private $e;

    protected function setUp() {
        $this->e = null;
    }

    public function testEnabledRegistration() {
        $this->assertTrue(WarningException::isRegistrationEnabled());
    }

    public function testSingleExceptions() {
        $this->assertTrue(WarningException::set(1, 11));
        $this->assertTrue(WarningException::set(2, 12));
        $this->assertTrue(WarningException::set(3, 13));
        $this->assertTrue(WarningException::set(4, 14));
        $this->assertTrue(WarningException::set(5, 15));
        
        $expected = array (
                        1 => 11,
                        2 => 12,
                        3 => 13,
                        4 => 14,
                        5 => 15 
        );
        $actual = WarningException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(11, WarningException::get(1));
        $this->assertSame(12, WarningException::get(2));
        $this->assertSame(13, WarningException::get(3));
        $this->assertSame(14, WarningException::get(4));
        $this->assertSame(15, WarningException::get(5));
    }

    public function testArrayExceptions() {
        $expected = array (
                        1 => 1001,
                        2 => 1002,
                        3 => 1003,
                        4 => 1004,
                        5 => 1005 
        );
        $this->assertTrue(WarningException::setArray($expected));
        
        $actual = WarningException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(1001, WarningException::get(1));
        $this->assertSame(1002, WarningException::get(2));
        $this->assertSame(1003, WarningException::get(3));
        $this->assertSame(1004, WarningException::get(4));
        $this->assertSame(1005, WarningException::get(5));
    }

    public function testGetlUndefinedKeys() {
        $this->assertNull(WarningException::get(-125));
        $this->assertNull(WarningException::get(999));
    }

    public function testGetInvalidKeys() {
        $this->assertNull(WarningException::get(0.0));
        $this->assertNull(WarningException::get(0.1));
        $this->assertNull(WarningException::get("hello"));
        $this->assertNull(WarningException::get("*-*"));
        $this->assertNull(WarningException::get(true));
        $this->assertNull(WarningException::get(null));
    }

    public function testDisableRegistration() {
        WarningException::disableRegistration();
        
        /* modify single exception */
        $this->assertFalse(WarningException::set(5, 15));
        $this->assertSame(1005, WarningException::get(5));
        
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
        $this->assertFalse(WarningException::setArray($modify));
        $actual = WarningException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(1005, WarningException::get(5));
    }

    public function testDisabledRegistration() {
        $this->assertFalse(WarningException::isRegistrationEnabled());
    }

    public function testNewException() {
        $this->e = new WarningException(0);
        $this->assertSame(0, $this->e->getCode());
        
        $this->e = new WarningException(5);
        $this->assertSame(5, $this->e->getCode());
    }
}
?>