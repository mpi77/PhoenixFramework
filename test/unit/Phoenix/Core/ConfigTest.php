<?php
/**
 * Config unit test.
 *
 * @version 1.0
 * @author MPI
 * */
include '../../../../Phoenix/Core/Config.php';
use \Phoenix\Core\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
    }
    
    public function testEnabledRegistration(){
        $this->assertTrue(Config::isRegistrationEnabled());
    }
    
    public function testConfigDefaults() {
        $this->assertEquals("/srv/www/htdocs/phoenix", Config::get(Config::KEY_DIR_ROOT));
        $this->assertEquals("/App", Config::get(Config::KEY_DIR_APP));
        $this->assertEquals("/Phoenix", Config::get(Config::KEY_DIR_PHOENIX));
        $this->assertEquals("/Temp", Config::get(Config::KEY_DIR_TEMP));
        $this->assertEquals("/Log", Config::get(Config::KEY_DIR_LOG));
        $this->assertEquals("/Vendor", Config::get(Config::KEY_DIR_VENDOR));
        $this->assertEquals("/Cache", Config::get(Config::KEY_DIR_CACHE));
        $this->assertEquals("http://localhost/phoenix/", Config::get(Config::KEY_SITE_FQDN));
        $this->assertEquals("/phoenix/", Config::get(Config::KEY_SITE_BASE));
        $this->assertEquals("500", Config::get(Config::KEY_SHUTDOWN_PAGE));
        $this->assertSame(0, Config::get(Config::KEY_ENVIRONMENT));
        $this->assertSame(4194304, Config::get(Config::KEY_LOG_SIZE));
        $this->assertEquals("Europe/Prague", Config::get(Config::KEY_TIME_ZONE));
        $this->assertSame(true, Config::get(Config::KEY_SESSION_INACTIVITY_ENABLED));
        $this->assertSame(1800, Config::get(Config::KEY_SESSION_INACTIVITY_TIMEOUT));
        $this->assertEquals("user/inactivity/", Config::get(Config::KEY_SESSION_INACTIVITY_REDIRECT_PATH));
        $this->assertSame(true, Config::get(Config::KEY_SESSION_FIXATION_DETECTION_ENABLED));
        $this->assertEquals("user/fixation/", Config::get(Config::KEY_SESSION_FIXATION_REDIRECT_PATH));
        $this->assertSame(1, Config::get(Config::KEY_DB_PRIMARY_POOL));
        $this->assertSame(2, Config::get(Config::KEY_DB_SECONDARY_POOL));
        $this->assertSame(3, Config::get(Config::KEY_DB_THIRD_POOL));
    }
    
    public function testConfigInvalidKeys() {
        $this->assertNull(Config::get("0"));
        $this->assertNull(Config::get("0.0"));
        $this->assertNull(Config::get(0.1));
        $this->assertNull(Config::get("-*-"));
        $this->assertNull(Config::get(-125));
        $this->assertNull(Config::get(0x55));
        $this->assertNull(Config::get(999));
        $this->assertNull(Config::get(1001));
        $this->assertNull(Config::get(true));
        $this->assertNull(Config::get(null));
    }
    
    public function testConfigPaths() {
        Config::set(Config::KEY_DIR_ROOT, "/srv/www");
        $this->assertEquals("/srv/www", Config::get(Config::KEY_DIR_ROOT));
        $this->assertEquals("/App", Config::get(Config::KEY_DIR_APP));
        $this->assertEquals("/srv/www", Config::getAbsoluteFolderPath(Config::KEY_DIR_ROOT));
        $this->assertEquals("/srv/www/App", Config::getAbsoluteFolderPath(Config::KEY_DIR_APP));
        $this->assertNull(Config::getAbsoluteFolderPath(999));
    }
    
    public function testDatabasePool() {
        /* get undefined pool */
        $this->assertNull(Config::getDatabasePool(1));
        
        /* add Database pools 1,2,3 */
        Config::setDatabasePool(1, "mysql", "localhost", "3306", "login", "", "db", "utf8");
        Config::setDatabasePool(2, "pgsql", "localhost", "659", "login", "", "db", "utf8");
        Config::setDatabasePool(3, "mysql", "localhost", "3306", "login2", "222", "db", "utf8");
        
        $expected1 = array(1=>"mysql", 2=>"localhost", 3=>"3306", 4=>"login", 5=>"", 6=>"db", 7=>"utf8");
        $actual1 = Config::getDatabasePool(1);
        $this->assertSame(array_diff($expected1, $actual1), array_diff($actual1, $expected1));
        
        $expected2 = array(1=>"pgsql", 2=>"localhost", 3=>"659", 4=>"login", 5=>"", 6=>"db", 7=>"utf8");
        $actual2 = Config::getDatabasePool(2);
        $this->assertSame(array_diff($expected2, $actual2), array_diff($actual2, $expected2));
        
        $expected3 = array(1=>"mysql", 2=>"localhost", 3=>"3306", 4=>"login2", 5=>"222", 6=>"db", 7=>"utf8");
        $actual3 = Config::getDatabasePool(3);
        $this->assertSame(array_diff($expected3, $actual3), array_diff($actual3, $expected3));
        
        /* modify Database pool 3 */
        Config::setDatabasePool(3, "oci", "localhost", "1234", "loop", "1234", "db", "utf8");
        $expected4 = array(1=>"oci", 2=>"localhost", 3=>"1234", 4=>"loop", 5=>"1234", 6=>"db", 7=>"utf8");
        $actual4 = Config::getDatabasePool(3);
        $this->assertSame(array_diff($expected4, $actual4), array_diff($actual4, $expected4));
        
        /* get undefined pool */
        $this->assertNull(Config::getDatabasePool(4));
    }
    
    public function testEmailPool() {
        /* get undefined pool */
        $this->assertNull(Config::getEmailPool(1));
    
        /* add Email pools 1,2,3 */
        Config::setEmailPool(1, "localhost", "25", "login", "pass", true, "tls", "Test1");
        Config::setEmailPool(2, "localhost", "25", "login", "pass", false, "", "Test2");
        Config::setEmailPool(3, "localhost", "25", "login", "pass", true, "xxx", "");
    
        $expected1 = array(1=>"localhost", 2=>"25", 3=>"login", 4=>"pass", 5=>true, 6=>"tls", 7=>"Test1");
        $actual1 = Config::getEmailPool(1);
        $this->assertSame(array_diff($expected1, $actual1), array_diff($actual1, $expected1));
    
        $expected2 = array(1=>"localhost", 2=>"25", 3=>"login", 4=>"pass", 5=>false, 6=>"", 7=>"Test2");
        $actual2 = Config::getEmailPool(2);
        $this->assertSame(array_diff($expected2, $actual2), array_diff($actual2, $expected2));
    
        $expected3 = array(1=>"localhost", 2=>"25", 3=>"login", 4=>"pass", 5=>true, 6=>"", 7=>"");
        $actual3 = Config::getEmailPool(3);
        $this->assertSame(array_diff($expected3, $actual3), array_diff($actual3, $expected3));
    
        /* modify Email pool 3 */
        Config::setEmailPool(3, "localhost", "25", "login", "passWORD", true, "ssl", "Test3");
        $expected4 = array(1=>"localhost", 2=>"25", 3=>"login", 4=>"passWORD", 5=>true, 6=>"ssl", 7=>"Test3");
        $actual4 = Config::getEmailPool(3);
        $this->assertSame(array_diff($expected4, $actual4), array_diff($actual4, $expected4));
    
        /* get undefined pool */
        $this->assertNull(Config::getEmailPool(4));
    }
    
    public function testDatabasePoolInvalidKeys() {
        $this->assertNull(Config::getDatabasePool(0.0));
        $this->assertNull(Config::getDatabasePool(0.1));
        $this->assertNull(Config::getDatabasePool(-125));
        $this->assertNull(Config::getDatabasePool(999));
        $this->assertNull(Config::getDatabasePool("hello"));
        $this->assertNull(Config::getDatabasePool("*-*"));
        $this->assertNull(Config::getDatabasePool(true));
        $this->assertNull(Config::getDatabasePool(null));
    }
    
    public function testEmailPoolInvalidKeys() {
        $this->assertNull(Config::getEmailPool(0.0));
        $this->assertNull(Config::getEmailPool(0.1));
        $this->assertNull(Config::getEmailPool(-125));
        $this->assertNull(Config::getEmailPool(999));
        $this->assertNull(Config::getEmailPool("hello"));
        $this->assertNull(Config::getEmailPool("*-*"));
        $this->assertNull(Config::getEmailPool(true));
        $this->assertNull(Config::getEmailPool(null));
    }
    
    public function testDisableRegistration() {
        Config::disableRegistration();
        
        /* modify DIR_ROOT */
        Config::set(Config::KEY_DIR_ROOT, "/srv/www/88");
        $this->assertEquals("/srv/www", Config::get(Config::KEY_DIR_ROOT));
        
        /* modify Database pool 1 */
        Config::setDatabasePool(1, "mysql", "localhost", "3306", "MODIFIED", "", "db", "utf8");
        $expected1 = array(1=>"mysql", 2=>"localhost", 3=>"3306", 4=>"login", 5=>"", 6=>"db", 7=>"utf8");
        $actual1 = Config::getDatabasePool(1);
        $this->assertSame(array_diff($expected1, $actual1), array_diff($actual1, $expected1));
        
        /* add Database pool 4 */
        Config::setDatabasePool(4, "mysql", "localhost", "3306", "login4", "444", "db", "utf8");
        $this->assertNull(Config::getDatabasePool(4));
        
        /* modify Email pool 1 */
        Config::setEmailPool(1, "localhost", "25", "MODIFIED", "pass", true, "tls", "Test1");
        $expected2 = array(1=>"localhost", 2=>"25", 3=>"login", 4=>"pass", 5=>true, 6=>"tls", 7=>"Test1");
        $actual2 = Config::getEmailPool(1);
        $this->assertSame(array_diff($expected2, $actual2), array_diff($actual2, $expected2));
        
        /* add Email pool 4 */
        Config::setEmailPool(4, "localhost", "25", "login", "passWORD", true, "ssl", "Test3");
        $this->assertNull(Config::getDatabasePool(4));
    }
    
    public function testDisabledRegistration(){
        $this->assertFalse(Config::isRegistrationEnabled());
    }
}
?>