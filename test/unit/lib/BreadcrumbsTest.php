<?php
/**
 * Breadcrumbs unit test.
 *
 * @version 1.0
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
        $this->assertNull($this->breadcrumbItem->getBody());
        $this->assertNull($this->breadcrumbItem->getUrl());
        $this->assertNull($this->breadcrumbItem->getTitle());
    }
}
?>