<?php
  /**
 * @package startpage
 * @subpackage tests
 * @author Ladislav Prskavec <ladislav@prskavec.net>
 * @copyright Copyright (c) 2007-2008
 * @version $Id: StartPageTest.php,v 720f1254016e 2009/03/09 08:56:54 ladislav $
 * @filesource
 */
/**
 * TestCase
 */
require_once 'PHPUnit/Framework.php';
/**
 * Class
 */
require_once dirname(__FILE__) . '/../src/startpage_class.php';
/**
 * Simple startpage test class. For all SVN testing.
 *
 * @package   startpage
 * @subpackage tests
 * @author    Ladislav Prskavec <ladislav@prskavec.net>
 * @copyright 2009 Ladislav Prskavec. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   $Id: StartPageTest.php,v 720f1254016e 2009/03/09 08:56:54 ladislav $
 * @link      http://blog.prskavec.net/
 */
class StartPageTest extends PHPUnit_Framework_TestCase
{
    /**
     * testMysqlInfo
     * @return bool
     */
    public function testMysqlInfo() {
        $this->assertContains('5.0', StartPage::mysqlInfo());
    }
    /**
     * testInfoIni
     * @return bool
     *
     */
    public function testInfoIni()
    {
        $this->assertEquals('Off', StartPage::infoIni('register_globals'));
        $this->assertEquals('On', StartPage::infoIni('display_errors'));
    }
    /**
     * testDataReplace
     * @return bool
     *
     */
    public function testDataReplace() {
        $this->assertContains("04.04.2008", StartPage::dateReplace("2008-04-04T10:29:47.609515Z"));
    }
    /**
     * testCheckExt
     * @return bool
     *
     */
    public function testCheckExt() {
        $this->assertContains("Installed", StartPage::checkExt('mysql'));
        $this->assertContains("Not available", StartPage::checkExt('pdo-oci'));
    }
    /**
     * testTruncate
     * @return bool
     *
     */
    public function testTruncate() {
        $this->assertEquals("Lor...", StartPage::truncate("Lorem ipsum",3));
    }


}
