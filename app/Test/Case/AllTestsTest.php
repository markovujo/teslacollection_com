<?php
/**
 * AllTestsTest class
 *
 * master test suite including all unit tests in codebase
 *
 * Following shell command will run all unit tests.
 * app/Console/cake test app AllTests
 *
 */
class AllTestsTest extends CakeTestSuite {
    public static function suite() {
        $suite = new CakeTestSuite('All unit tests');
        $suite->addTestDirectory(TESTS . 'Case/Model');
        
        return $suite;
    }
}
