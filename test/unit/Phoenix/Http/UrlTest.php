<?php
/**
 * Url unit test.
 *
 * @version 1.2
 * @author MPI
 * */
include '../../../../Phoenix/Http/Url.php';
use \Phoenix\Http\Url;
class UrlTest extends \PHPUnit_Framework_TestCase {
    private $url;

    protected function setUp() {
        $this->url = null;
    }

    public function testEmptyUrl() {
        $this->url = new Url();
        $this->assertEquals("", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("", $this->url->getHost());
        $this->assertEquals("", $this->url->getPort());
        $this->assertEquals("", $this->url->getBasePath());
        $this->assertEquals("", $this->url->getRelativeUrl());
        $this->assertEquals("", $this->url->getAuthority());
        $this->assertEquals("", $this->url->getPath());
        $this->assertEquals("", $this->url->getQuery());
        $this->assertEquals("", $this->url->getFragment());
        $this->assertEquals("", $this->url->getQueryParameter("route"));
        $this->assertEquals("//", $this->url->getAbsoluteUrl());
        
        $this->url->setScheme("sdp");
        $this->assertEquals("sdp://", $this->url->getAbsoluteUrl());
        
        $this->url->setUser("admin");
        $this->url->setPassword("pasw");
        $this->url->setHost("domain.org");
        $this->url->setPort("5589");
        $this->url->setPath("/live/index.php");
        $this->assertEquals("sdp://admin:pasw@domain.org:5589/live/index.php", $this->url->getAbsoluteUrl());
        
        $this->url->setQuery("codec=xvid");
        $this->url->setQueryParameter("bitrate", "256");
        $this->url->setFragment("lixx");
        $this->assertEquals("sdp://admin:pasw@domain.org:5589/live/index.php?codec=xvid&bitrate=256#lixx", $this->url->getAbsoluteUrl());
        
        $this->url->appendQuery("aa=bb");
        $this->url->appendQuery(array (
                        "xx" => "uu" 
        ));
        
        $this->assertEquals("sdp", $this->url->getScheme());
        $this->assertEquals("admin", $this->url->getUser());
        $this->assertEquals("pasw", $this->url->getPassword());
        $this->assertEquals("domain.org", $this->url->getHost());
        $this->assertEquals("5589", $this->url->getPort());
        $this->assertEquals("/live/", $this->url->getBasePath());
        $this->assertEquals("index.php?codec=xvid&bitrate=256&aa=bb&xx=uu#lixx", $this->url->getRelativeUrl());
        $this->assertEquals("admin:pasw@domain.org:5589", $this->url->getAuthority());
        $this->assertEquals("/live/index.php", $this->url->getPath());
        $this->assertEquals("codec=xvid&bitrate=256&aa=bb&xx=uu", $this->url->getQuery());
        $this->assertEquals("xvid", $this->url->getQueryParameter("codec"));
        $this->assertSame(array (
                        "codec" => "xvid",
                        "bitrate" => "256",
                        "aa" => "bb",
                        "xx" => "uu" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("lixx", $this->url->getFragment());
        $this->assertEquals("sdp://admin:pasw@domain.org:5589/live/index.php?codec=xvid&bitrate=256&aa=bb&xx=uu#lixx", $this->url->getAbsoluteUrl());
    }

    public function testParseRFCUrl() {
        $this->url = new Url("hxxp://user:pass@www.localhost.com:1234/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("hxxp", $this->url->getScheme());
        $this->assertEquals("user", $this->url->getUser());
        $this->assertEquals("pass", $this->url->getPassword());
        $this->assertEquals("www.localhost.com", $this->url->getHost());
        $this->assertEquals("1234", $this->url->getPort());
        $this->assertEquals("/phoenix/", $this->url->getBasePath());
        $this->assertEquals("index.php?route=index&action=welcome#hx", $this->url->getRelativeUrl());
        $this->assertEquals("user:pass@www.localhost.com:1234", $this->url->getAuthority());
        $this->assertEquals("/phoenix/index.php", $this->url->getPath());
        $this->assertEquals("route=index&action=welcome", $this->url->getQuery());
        $this->assertSame(array (
                        "route" => "index",
                        "action" => "welcome" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("hx", $this->url->getFragment());
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->assertEquals("hxxp://user:pass@www.localhost.com:1234/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
    }

    public function testParseHttpUrl() {
        $this->url = new Url("http://www.localhost.net:80/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("http", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("www.localhost.net", $this->url->getHost());
        $this->assertEquals("80", $this->url->getPort());
        $this->assertEquals("/phoenix/", $this->url->getBasePath());
        $this->assertEquals("index.php?route=index&action=welcome#hx", $this->url->getRelativeUrl());
        $this->assertEquals("www.localhost.net", $this->url->getAuthority());
        $this->assertEquals("/phoenix/index.php", $this->url->getPath());
        $this->assertEquals("route=index&action=welcome", $this->url->getQuery());
        $this->assertSame(array (
                        "route" => "index",
                        "action" => "welcome" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("hx", $this->url->getFragment());
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->assertEquals("http://www.localhost.net/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
        
        $this->url = new Url("http://www.localhost.org/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("http", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("www.localhost.org", $this->url->getHost());
        $this->assertEquals("", $this->url->getPort());
        $this->assertEquals("/phoenix/", $this->url->getBasePath());
        $this->assertEquals("index.php?route=index&action=welcome#hx", $this->url->getRelativeUrl());
        $this->assertEquals("www.localhost.org", $this->url->getAuthority());
        $this->assertEquals("/phoenix/index.php", $this->url->getPath());
        $this->assertEquals("route=index&action=welcome", $this->url->getQuery());
        $this->assertSame(array (
                        "route" => "index",
                        "action" => "welcome" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("hx", $this->url->getFragment());
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->assertEquals("http://www.localhost.org/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
    }

    public function testParseHttpsUrl() {
        $this->url = new Url("https://www.localhost.org:443/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("https", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("www.localhost.org", $this->url->getHost());
        $this->assertEquals("443", $this->url->getPort());
        $this->assertEquals("/phoenix/", $this->url->getBasePath());
        $this->assertEquals("index.php?route=index&action=welcome#hx", $this->url->getRelativeUrl());
        $this->assertEquals("www.localhost.org", $this->url->getAuthority());
        $this->assertEquals("/phoenix/index.php", $this->url->getPath());
        $this->assertEquals("route=index&action=welcome", $this->url->getQuery());
        $this->assertSame(array (
                        "route" => "index",
                        "action" => "welcome" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("hx", $this->url->getFragment());
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->assertEquals("https://www.localhost.org/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
        
        $this->url = new Url("https://www.localhost.net/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("https", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("www.localhost.net", $this->url->getHost());
        $this->assertEquals("", $this->url->getPort());
        $this->assertEquals("/phoenix/", $this->url->getBasePath());
        $this->assertEquals("index.php?route=index&action=welcome#hx", $this->url->getRelativeUrl());
        $this->assertEquals("www.localhost.net", $this->url->getAuthority());
        $this->assertEquals("/phoenix/index.php", $this->url->getPath());
        $this->assertEquals("route=index&action=welcome", $this->url->getQuery());
        $this->assertSame(array (
                        "route" => "index",
                        "action" => "welcome" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("hx", $this->url->getFragment());
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->assertEquals("https://www.localhost.net/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
    }

    public function testUrlQueryPart() {
        $this->url = new Url("https://www.localhost.org:443/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->url->setQueryParameter("route", "RXX");
        $this->assertEquals("RXX", $this->url->getQueryParameter("route"));
        $this->assertSame(array (
                        "route" => "RXX",
                        "action" => "welcome" 
        ), $this->url->getQueryParameters());
    }

    public function testUrlModifications() {
        $this->url = new Url("hxxp://user:pass@www.localhost.com:1234/phoenix/index.php?route=index&action=welcome#hx");
        
        $this->url->setScheme("sdp");
        $this->url->setUser("admin");
        $this->url->setPassword("pasw");
        $this->url->setHost("domain.org");
        $this->url->setPort("5589");
        $this->url->setPath("/live/index.php");
        $this->url->setQuery("codec=xvid");
        $this->url->setQueryParameter("bitrate", "256");
        $this->url->setFragment("lixx");
        $this->url->appendQuery("aa=bb");
        $this->url->appendQuery(array (
                        "xx" => "uu" 
        ));
        
        $this->assertEquals("sdp", $this->url->getScheme());
        $this->assertEquals("admin", $this->url->getUser());
        $this->assertEquals("pasw", $this->url->getPassword());
        $this->assertEquals("domain.org", $this->url->getHost());
        $this->assertEquals("5589", $this->url->getPort());
        $this->assertEquals("/live/", $this->url->getBasePath());
        $this->assertEquals("index.php?codec=xvid&bitrate=256&aa=bb&xx=uu#lixx", $this->url->getRelativeUrl());
        $this->assertEquals("admin:pasw@domain.org:5589", $this->url->getAuthority());
        $this->assertEquals("/live/index.php", $this->url->getPath());
        $this->assertEquals("codec=xvid&bitrate=256&aa=bb&xx=uu", $this->url->getQuery());
        $this->assertSame(array (
                        "codec" => "xvid",
                        "bitrate" => "256",
                        "aa" => "bb",
                        "xx" => "uu" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("xvid", $this->url->getQueryParameter("codec"));
        $this->assertEquals("lixx", $this->url->getFragment());
    }

    public function testUrlEqual() {
        $this->url = new Url("hxxp://user:pass@www.localhost.com:1234/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertTrue($this->url->isEqual("hxxp://user:pass@www.localhost.com:1234/phoenix/index.php?route=index&action=welcome#hx"));
        $this->assertFalse($this->url->isEqual("hxxp://user:pass@www.localhost.com:12/phoenix/index.php?route=index&action=welcome#hx"));
    }

    public function testUrlCanonicalize() {
        $this->url = new Url("hxxp://user:pass%40www.localhost.com:1234/phoenix/index.php?route=index&action=welcome#hx");
        $this->url->canonicalize();
        $this->assertEquals("hxxp://user:pass@www.localhost.com:1234/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
    }

    public function testParsedHomepageUrl() {
        $this->url = new Url("www.localhost.com?action=index");
        $this->assertEquals("", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("", $this->url->getHost());
        $this->assertEquals("", $this->url->getPort());
        $this->assertEquals("", $this->url->getBasePath());
        $this->assertEquals("www.localhost.com?action=index", $this->url->getRelativeUrl());
        $this->assertEquals("", $this->url->getAuthority());
        $this->assertEquals("www.localhost.com", $this->url->getPath());
        $this->assertEquals("action=index", $this->url->getQuery());
        $this->assertSame(array (
                        "action" => "index" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("", $this->url->getFragment());
        $this->assertEquals("", $this->url->getQueryParameter("route"));
        $this->assertEquals("//www.localhost.com?action=index", $this->url->getAbsoluteUrl());
    }

    public function testRewritedUrl() {
        $this->url = new Url("http://localhost.com/gallery/view/1/?sort=asc");
        $this->url->setQuery(array (
                        "route" => "page",
                        "action" => "edit",
                        "id" => "1" 
        ));
        $script = "/index.php";
        $path = $this->url->getPath();
        if ($path !== $script) {
            $max = min(strlen($path), strlen($script));
            for($i = 0; $i < $max && $path[$i] === $script[$i]; $i++)
                ;
            $path = $i ? substr($path, 0, strrpos($path, "/", $i - $max - 1) + 1) : "/";
        }
        $this->url->setPath($path);
        
        $this->assertEquals("http", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("localhost.com", $this->url->getHost());
        $this->assertEquals("", $this->url->getPort());
        $this->assertEquals("/", $this->url->getBasePath());
        $this->assertEquals("?route=page&action=edit&id=1", $this->url->getRelativeUrl());
        $this->assertEquals("localhost.com", $this->url->getAuthority());
        $this->assertEquals("/", $this->url->getPath());
        $this->assertEquals("route=page&action=edit&id=1", $this->url->getQuery());
        $this->assertSame(array (
                        "route" => "page",
                        "action" => "edit",
                        "id" => "1" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("", $this->url->getFragment());
        $this->assertEquals("page", $this->url->getQueryParameter("route"));
        $this->assertEquals("http://localhost.com/?route=page&action=edit&id=1", $this->url->getAbsoluteUrl());
    }

    public function testRewritedUrl2() {
        $this->url = new Url("http://localhost.com/gallery/view/1/?sort=asc");
        $this->url->appendQuery(array (
                        "route" => "page",
                        "action" => "edit",
                        "id" => "1" 
        ));
        $script = "/index.php";
        $path = $this->url->getPath();
        if ($path !== $script) {
            $max = min(strlen($path), strlen($script));
            for($i = 0; $i < $max && $path[$i] === $script[$i]; $i++)
                ;
            $path = $i ? substr($path, 0, strrpos($path, "/", $i - $max - 1) + 1) : "/";
        }
        $this->url->setPath($path);
        
        $this->assertEquals("http", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("localhost.com", $this->url->getHost());
        $this->assertEquals("", $this->url->getPort());
        $this->assertEquals("/", $this->url->getBasePath());
        $this->assertEquals("?sort=asc&route=page&action=edit&id=1", $this->url->getRelativeUrl());
        $this->assertEquals("localhost.com", $this->url->getAuthority());
        $this->assertEquals("/", $this->url->getPath());
        $this->assertEquals("sort=asc&route=page&action=edit&id=1", $this->url->getQuery());
        $this->assertSame(array (
                        "sort" => "asc",
                        "route" => "page",
                        "action" => "edit",
                        "id" => "1" 
        ), $this->url->getQueryParameters());
        $this->assertEquals("", $this->url->getFragment());
        $this->assertEquals("page", $this->url->getQueryParameter("route"));
        $this->assertEquals("http://localhost.com/?sort=asc&route=page&action=edit&id=1", $this->url->getAbsoluteUrl());
    }
}
?>