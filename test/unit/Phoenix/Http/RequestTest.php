<?php
/**
 * Request unit test.
 *
 * @version 1.1
 * @author MPI
 * */
include '../../../../Phoenix/Http/Url.php';
include '../../../../Phoenix/Http/Request.php';

use \Phoenix\Http\Url;
use \Phoenix\Http\Request;
class RequestTest extends \PHPUnit_Framework_TestCase {
    private $request;

    protected function setUp() {
        $this->request = null;
    }

    public function testMinimalConstructor() {
        $url = new Url("http://localhost.com/phoenix/index.php?route=index&action=index");
        $this->request = new Request($url, "GET");
        $this->assertEquals("http://localhost.com/phoenix/index.php?route=index&action=index", $this->request->getUrl()->getAbsoluteUrl());
        $this->assertEquals("GET", $this->request->getMethod());
        $this->assertTrue($this->request->isMethod("GET"));
        $this->assertTrue($this->request->isGet());
        $this->assertFalse($this->request->isPost());
        $this->assertFalse($this->request->isAjax());
        $this->assertTrue($this->request->isHttp());
        $this->assertFalse($this->request->isHttps());
        
        $this->assertNull($this->request->getCookie("test"));
        $this->assertSame(array (), $this->request->getCookies());
        $this->assertNull($this->request->getFile("unknown", "file"));
        $this->assertSame(array (), $this->request->getFiles());
        $this->assertNull($this->request->getHeader("unknown"));
        $this->assertSame(array (), $this->request->getHeaders());
        $this->assertSame(array (), $this->request->getPost());
        $this->assertNull($this->request->getPost("unknown"));
        $this->assertNull($this->request->getReferer());
        $this->assertNull($this->request->getRemoteAddress());
        $this->assertNull($this->request->getRemoteHost());
    }

    public function testPost() {
        $url = new Url("http://localhost.com/phoenix/index.php?route=index&action=index");
        $post = array (
                        "user" => "test",
                        "password" => "hellokitty",
                        "id" => "596" 
        );
        $this->request = new Request($url, "POST", $post);
        $this->assertEquals("http://localhost.com/phoenix/index.php?route=index&action=index", $this->request->getUrl()->getAbsoluteUrl());
        $this->assertEquals("POST", $this->request->getMethod());
        $this->assertTrue($this->request->isMethod("POST"));
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isPost());
        $this->assertFalse($this->request->isAjax());
        $this->assertTrue($this->request->isHttp());
        $this->assertFalse($this->request->isHttps());
        
        $this->assertNull($this->request->getCookie("test"));
        $this->assertSame(array (), $this->request->getCookies());
        $this->assertNull($this->request->getFile("unknown", "file"));
        $this->assertSame(array (), $this->request->getFiles());
        $this->assertNull($this->request->getHeader("unknown"));
        $this->assertSame(array (), $this->request->getHeaders());
        $this->assertSame($post, $this->request->getPost());
        $this->assertSame("test", $this->request->getPost("user"));
        $this->assertSame("hellokitty", $this->request->getPost("password"));
        $this->assertSame("596", $this->request->getPost("id"));
        $this->assertNull($this->request->getReferer());
        $this->assertNull($this->request->getRemoteAddress());
        $this->assertNull($this->request->getRemoteHost());
    }

    public function testFiles() {
        $url = new Url("http://localhost.com/phoenix/index.php?route=index&action=index");
        $files = array (
                        "pool-x" => array (
                                        0 => array (
                                                        "name" => "abc.png",
                                                        "type" => "image/png",
                                                        "tmp_name" => "/tmp/x1587",
                                                        "error" => "0",
                                                        "size" => "155895" 
                                        ),
                                        1 => array (
                                                        "name" => "def.png",
                                                        "type" => "image/png",
                                                        "tmp_name" => "/tmp/x1507",
                                                        "error" => "0",
                                                        "size" => "15" 
                                        ),
                                        2 => array (
                                                        "name" => "ghi.png",
                                                        "type" => "image/png",
                                                        "tmp_name" => "/tmp/x17",
                                                        "error" => "0",
                                                        "size" => "1558" 
                                        ) 
                        ) 
        );
        $this->request = new Request($url, "POST", null, $files);
        $this->assertEquals("http://localhost.com/phoenix/index.php?route=index&action=index", $this->request->getUrl()->getAbsoluteUrl());
        $this->assertEquals("POST", $this->request->getMethod());
        $this->assertTrue($this->request->isMethod("POST"));
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isPost());
        $this->assertFalse($this->request->isAjax());
        $this->assertTrue($this->request->isHttp());
        $this->assertFalse($this->request->isHttps());
        
        $this->assertNull($this->request->getCookie("test"));
        $this->assertSame(array (), $this->request->getCookies());
        
        $this->assertSame(array (
                        "name" => "abc.png",
                        "type" => "image/png",
                        "tmp_name" => "/tmp/x1587",
                        "error" => "0",
                        "size" => "155895" 
        ), $this->request->getFile("pool-x", "abc.png"));
        $this->assertSame($files, $this->request->getFiles());
        $this->assertNull($this->request->getHeader("unknown"));
        $this->assertSame(array (), $this->request->getHeaders());
        $this->assertSame(array (), $this->request->getPost());
        $this->assertNull($this->request->getPost("user"));
        $this->assertNull($this->request->getReferer());
        $this->assertNull($this->request->getRemoteAddress());
        $this->assertNull($this->request->getRemoteHost());
    }

    public function testCookies() {
        $url = new Url("http://localhost.com/phoenix/index.php?route=index&action=index");
        $cookies = array (
                        "user" => "test",
                        "password" => "hellokitty" 
        );
        $this->request = new Request($url, "POST", null, null, $cookies);
        $this->assertEquals("http://localhost.com/phoenix/index.php?route=index&action=index", $this->request->getUrl()->getAbsoluteUrl());
        $this->assertEquals("POST", $this->request->getMethod());
        $this->assertTrue($this->request->isMethod("POST"));
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isPost());
        $this->assertFalse($this->request->isAjax());
        $this->assertTrue($this->request->isHttp());
        $this->assertFalse($this->request->isHttps());
        
        $this->assertSame("test", $this->request->getCookie("user"));
        $this->assertSame($cookies, $this->request->getCookies());
        $this->assertNull($this->request->getFile("unknown", "file"));
        $this->assertSame(array (), $this->request->getFiles());
        $this->assertNull($this->request->getHeader("unknown"));
        $this->assertSame(array (), $this->request->getHeaders());
        $this->assertSame(array (), $this->request->getPost());
        $this->assertNull($this->request->getPost("user"));
        $this->assertNull($this->request->getReferer());
        $this->assertNull($this->request->getRemoteAddress());
        $this->assertNull($this->request->getRemoteHost());
    }

    public function testHeaders() {
        $url = new Url("http://localhost.com/phoenix/index.php?route=index&action=index");
        $headers = array (
                        "user-agent" => "Firefox",
                        "referer" => "http://localhost/",
                        "accept-language" => "cs,en-us;q=0.7,en;q=0.3" 
        );
        $this->request = new Request($url, "GET", null, null, null, $headers);
        $this->assertEquals("http://localhost.com/phoenix/index.php?route=index&action=index", $this->request->getUrl()->getAbsoluteUrl());
        $this->assertEquals("GET", $this->request->getMethod());
        $this->assertTrue($this->request->isMethod("GET"));
        $this->assertTrue($this->request->isGet());
        $this->assertFalse($this->request->isPost());
        $this->assertFalse($this->request->isAjax());
        $this->assertTrue($this->request->isHttp());
        $this->assertFalse($this->request->isHttps());
        
        $this->assertNull($this->request->getCookie("user"));
        $this->assertSame(array (), $this->request->getCookies());
        $this->assertNull($this->request->getFile("unknown", "file"));
        $this->assertSame(array (), $this->request->getFiles());
        $this->assertSame("Firefox", $this->request->getHeader("user-agent"));
        $this->assertSame($headers, $this->request->getHeaders());
        $this->assertSame(array (), $this->request->getPost());
        $this->assertNull($this->request->getPost("user"));
        $this->assertSame("http://localhost/", $this->request->getReferer());
        $this->assertNull($this->request->getRemoteAddress());
        $this->assertNull($this->request->getRemoteHost());
        
        $langs = array (
                        "cs",
                        "en",
                        "ro",
                        "it" 
        );
        $this->assertSame("cs", $this->request->detectLanguage($langs));
    }

    public function testRemote() {
        $url = new Url("http://localhost.com/phoenix/index.php?route=index&action=index");
        
        $this->request = new Request($url, "GET", null, null, null, null, "::1", "localhost");
        $this->assertEquals("http://localhost.com/phoenix/index.php?route=index&action=index", $this->request->getUrl()->getAbsoluteUrl());
        $this->assertEquals("GET", $this->request->getMethod());
        $this->assertTrue($this->request->isMethod("GET"));
        $this->assertTrue($this->request->isGet());
        $this->assertFalse($this->request->isPost());
        $this->assertFalse($this->request->isAjax());
        $this->assertTrue($this->request->isHttp());
        $this->assertFalse($this->request->isHttps());
        
        $this->assertNull($this->request->getCookie("user"));
        $this->assertSame(array (), $this->request->getCookies());
        $this->assertNull($this->request->getFile("unknown", "file"));
        $this->assertSame(array (), $this->request->getFiles());
        $this->assertNull($this->request->getHeader("user-agent"));
        $this->assertSame(array (), $this->request->getHeaders());
        $this->assertSame(array (), $this->request->getPost());
        $this->assertNull($this->request->getPost("user"));
        $this->assertNull($this->request->getReferer());
        $this->assertSame("::1", $this->request->getRemoteAddress());
        $this->assertSame("localhost", $this->request->getRemoteHost());
    }
}
?>