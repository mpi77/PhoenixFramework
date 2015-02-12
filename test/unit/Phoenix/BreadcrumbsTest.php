<?php
/**
 * Breadcrumbs unit test.
 *
 * @version 1.1
 * @author MPI
 * */
include '../../app/lib/Breadcrumbs.class.php';
class BreadcrumbsTest extends PHPUnit_Framework_TestCase {
    private $breadcrumbItem;

    protected function setUp() {
        $this->breadcrumbItem = null;
    }

    public function testEmptyConstructor() {
        $this->breadcrumbItem = new Breadcrumbs(null, null);
        $this->assertNull($this->breadcrumbItem->getUrl());
        $this->assertNull($this->breadcrumbItem->getBody());
        $this->assertNull($this->breadcrumbItem->getTitle());
    }
    
    public function testValidEmptyUrlBody() {
        $this->breadcrumbItem = new Breadcrumbs("", 15);
        $this->assertEquals("", $this->breadcrumbItem->getUrl());
        $this->assertEquals(15, $this->breadcrumbItem->getBody());
        $this->assertNull($this->breadcrumbItem->getTitle());
    }
    
    public function testValidUrlBody() {
        $this->breadcrumbItem = new Breadcrumbs("user/example/", 15);
        $this->assertEquals("user/example/", $this->breadcrumbItem->getUrl());
        $this->assertEquals(15, $this->breadcrumbItem->getBody());
        $this->assertNull($this->breadcrumbItem->getTitle());
    }
    
    public function testValidUrlBodyTitle() {
        $this->breadcrumbItem = new Breadcrumbs("user/example/", 15, 55);
        $this->assertEquals("user/example/", $this->breadcrumbItem->getUrl());
        $this->assertEquals(15, $this->breadcrumbItem->getBody());
        $this->assertEquals(55, $this->breadcrumbItem->getTitle());
    }
    
    public function testValidUrlInvalidBodyTitle() {
        $this->breadcrumbItem = new Breadcrumbs("user/example/", null, 0.0);
        $this->assertEquals("user/example/", $this->breadcrumbItem->getUrl());
        $this->assertNull($this->breadcrumbItem->getBody());
        $this->assertNull($this->breadcrumbItem->getTitle());
    }
    
    public function testValidUrlBodyInvalidTitle() {
        $this->breadcrumbItem = new Breadcrumbs("user/example/", 15, 0.0);
        $this->assertEquals("user/example/", $this->breadcrumbItem->getUrl());
        $this->assertEquals(15, $this->breadcrumbItem->getBody());
        $this->assertNull($this->breadcrumbItem->getTitle());
    }
    
    public function testInvalidUrlBodyTitle() {
        $this->breadcrumbItem = new Breadcrumbs(null, true, 0.0);
        $this->assertNull($this->breadcrumbItem->getUrl());
        $this->assertNull($this->breadcrumbItem->getBody());
        $this->assertNull($this->breadcrumbItem->getTitle());
    }
}
?>