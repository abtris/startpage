<?php
  /**
 * @package startpage
 * @subpackage tests
 * @author Ladislav Prskavec <ladislav@prskavec.net>
 * @copyright Copyright (c) 2007-2008
 * @version $Id: AllTests.php,v 94af1ea64640 2009/04/17 13:44:14 ladislav $
 * @filesource
 */
/**
 * Load UT framework mandatory files
 */
require_once 'PHPUnit/Framework.php';
/**
 * Include all test classes 
 */
require_once 'SampleTest.php';
require_once 'StartPageTest.php';
/**
 * @package startpage
 * @subpackage tests
 */
class StartPage_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Start Page tests');
        $suite->addTestSuite('SampleTest');
        $suite->addTestSuite('StartPageTest');
        // run tests
        return $suite;
    }
}