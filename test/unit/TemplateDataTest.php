<?php
/**
 * Template data unit test.
 *
 * @version 1.1
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
        $this->assertEmpty($this->data->getAll());
    }

    public function testSimpleDataStore() {
        $a = array (
                        "key" => "value",
                        "key2" => "value2",
                        "key3" => "value3" 
        );
        $this->data = new TemplateData($a);
        $this->assertEquals("value", $this->data->get("key"));
        $this->assertEquals("value2", $this->data->get("key2"));
        $this->assertEquals("value3", $this->data->get("key3"));
        $this->assertSame($a, $this->data->getAll());
        
    }
}
?>