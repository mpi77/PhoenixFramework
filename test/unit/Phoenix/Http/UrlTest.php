<?php
/**
 * Url unit test.
 *
 * @version 1.1
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
        $this->assertEquals("hx", $this->url->getFragment());
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->assertEquals("http://www.localhost.net/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
        
        $this->url = new Url("http://www.localhost.org/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("http", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("www.localhost.org", $this->url->getHost());
        $this->assertEquals("80", $this->url->getPort());
        $this->assertEquals("/phoenix/", $this->url->getBasePath());
        $this->assertEquals("index.php?route=index&action=welcome#hx", $this->url->getRelativeUrl());
        $this->assertEquals("www.localhost.org", $this->url->getAuthority());
        $this->assertEquals("/phoenix/index.php", $this->url->getPath());
        $this->assertEquals("route=index&action=welcome", $this->url->getQuery());
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
        $this->assertEquals("hx", $this->url->getFragment());
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->assertEquals("https://www.localhost.org/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
        
        $this->url = new Url("https://www.localhost.net/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("https", $this->url->getScheme());
        $this->assertEquals("", $this->url->getUser());
        $this->assertEquals("", $this->url->getPassword());
        $this->assertEquals("www.localhost.net", $this->url->getHost());
        $this->assertEquals("443", $this->url->getPort());
        $this->assertEquals("/phoenix/", $this->url->getBasePath());
        $this->assertEquals("index.php?route=index&action=welcome#hx", $this->url->getRelativeUrl());
        $this->assertEquals("www.localhost.net", $this->url->getAuthority());
        $this->assertEquals("/phoenix/index.php", $this->url->getPath());
        $this->assertEquals("route=index&action=welcome", $this->url->getQuery());
        $this->assertEquals("hx", $this->url->getFragment());
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->assertEquals("https://www.localhost.net/phoenix/index.php?route=index&action=welcome#hx", $this->url->getAbsoluteUrl());
    }

    public function testUrlQueryPart() {
        $this->url = new Url("https://www.localhost.org:443/phoenix/index.php?route=index&action=welcome#hx");
        $this->assertEquals("index", $this->url->getQueryParameter("route"));
        $this->url->setQueryParameter("route", "RXX");
        $this->assertEquals("RXX", $this->url->getQueryParameter("route"));
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
}
?>