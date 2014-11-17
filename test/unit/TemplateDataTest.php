<?php
/**
 * Template data unit test.
 *
 * @version 1.2
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
        $this->assertTrue($this->data->has("key"));
        $this->assertTrue($this->data->has("key2"));
        $this->assertTrue($this->data->has("key3"));
        $this->assertEquals("value", $this->data->get("key"));
        $this->assertEquals("value2", $this->data->get("key2"));
        $this->assertEquals("value3", $this->data->get("key3"));
        $this->assertSame($a, $this->data->getAll());
        
        $b = array (
                        "key4" => "value4" 
        );
        $a = array_merge($a, $b);
        $this->data->set("key4", "value4");
        
        $this->assertTrue($this->data->has("key4"));
        $this->assertEquals("value4", $this->data->get("key4"));
        $this->assertSame($a, $this->data->getAll());
        
        $this->data->set("key4", "value5");
        $a["key4"] = "value5";
        
        $this->assertEquals("value5", $this->data->get("key4"));
        $this->assertSame($a, $this->data->getAll());
        
        $this->assertNull($this->data->get(true));
        $this->assertNull($this->data->get(2.0));
        $this->assertNull($this->data->get($this->getMock("ExampleObj")));
    }
}
?>