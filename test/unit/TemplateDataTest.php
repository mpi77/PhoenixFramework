<?php
/**
 * Template data unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../app/TemplateData.class.php';
class TemplateDataTest extends PHPUnit_Framework_TestCase {
    private $data;

    protected function setUp() {
        $this->data = null;
    }
    
    public function testEmptyConstructor() {
        $this->data = new TemplateData();
        $this->assertEmpty($this->data->get());
    }
}
?>