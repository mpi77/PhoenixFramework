<?php
/**
 * NoticeException unit test.
 *
 * @version 1.1
 * @author MPI
 * */
include '../../../../Phoenix/Exceptions/BaseException.php';
include '../../../../Phoenix/Exceptions/NoticeException.php';

use \Phoenix\Exceptions\BaseException;
use \Phoenix\Exceptions\NoticeException;
class NoticeExceptionTest extends \PHPUnit_Framework_TestCase {
    private $e;

    protected function setUp() {
        $this->e = null;
    }

    public function testEnabledRegistration() {
        $this->assertTrue(NoticeException::isRegistrationEnabled());
    }

    public function testSingleExceptions() {
        $this->assertTrue(NoticeException::set(1, 11));
        $this->assertTrue(NoticeException::set(2, 12));
        $this->assertTrue(NoticeException::set(3, 13));
        $this->assertTrue(NoticeException::set(4, 14));
        $this->assertTrue(NoticeException::set(5, 15));
        
        $expected = array (
                        1 => 11,
                        2 => 12,
                        3 => 13,
                        4 => 14,
                        5 => 15 
        );
        $actual = NoticeException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(11, NoticeException::get(1));
        $this->assertSame(12, NoticeException::get(2));
        $this->assertSame(13, NoticeException::get(3));
        $this->assertSame(14, NoticeException::get(4));
        $this->assertSame(15, NoticeException::get(5));
    }

    public function testArrayExceptions() {
        $expected = array (
                        1 => 1001,
                        2 => 1002,
                        3 => 1003,
                        4 => 1004,
                        5 => 1005 
        );
        $this->assertTrue(NoticeException::setArray($expected));
        
        $actual = NoticeException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(1001, NoticeException::get(1));
        $this->assertSame(1002, NoticeException::get(2));
        $this->assertSame(1003, NoticeException::get(3));
        $this->assertSame(1004, NoticeException::get(4));
        $this->assertSame(1005, NoticeException::get(5));
    }

    public function testGetlUndefinedKeys() {
        $this->assertNull(NoticeException::get(-125));
        $this->assertNull(NoticeException::get(999));
    }

    public function testGetInvalidKeys() {
        $this->assertNull(NoticeException::get(0.0));
        $this->assertNull(NoticeException::get(0.1));
        $this->assertNull(NoticeException::get("hello"));
        $this->assertNull(NoticeException::get("*-*"));
        $this->assertNull(NoticeException::get(true));
        $this->assertNull(NoticeException::get(null));
    }

    public function testDisableRegistration() {
        NoticeException::disableRegistration();
        
        /* modify single exception */
        $this->assertFalse(NoticeException::set(5, 15));
        $this->assertSame(1005, NoticeException::get(5));
        
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
        $this->assertFalse(NoticeException::setArray($modify));
        $actual = NoticeException::getAll();
        $this->assertSame(array_diff($expected, $actual), array_diff($actual, $expected));
        
        $this->assertSame(1005, NoticeException::get(5));
    }

    public function testDisabledRegistration() {
        $this->assertFalse(NoticeException::isRegistrationEnabled());
    }

    public function testNewException() {
        $this->e = new NoticeException(0);
        $this->assertSame(0, $this->e->getCode());
        
        $this->e = new NoticeException(5);
        $this->assertSame(5, $this->e->getCode());
    }
}
?>