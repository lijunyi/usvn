<?php
/**
 * Class to manipulate config file
 *
 * @author Team USVN <contact@usvn.info>
 * @link http://www.usvn.info
 * @license http://www.cecill.info/licences/Licence_CeCILL_V2-en.txt CeCILL V2
 * @copyright Copyright 2007, Team USVN
 * @since 0.5
 * @package usvn
 * @subpackage config
 *
 * This software has been written at EPITECH <http://www.epitech.net>
 * EPITECH, European Institute of Technology, Paris - FRANCE -
 * This project has been realised as part of
 * end of studies project.
 *
 * $Id: IniTest.php 1188 2007-10-06 12:03:17Z crivis_s $
 */

// Call USVN_Config_IniTest::main() if this source file is executed directly.
if (!defined("PHPUnit_MAIN_METHOD")) {
    define("PHPUnit_MAIN_METHOD", "USVN_Config_IniTest::main");
}

require_once "PHPUnit/Framework/TestCase.php";
require_once "PHPUnit/Framework/TestSuite.php";

require_once 'library/USVN/autoload.php';

/**
 * Test class for USVN_Config_Ini.
 * Generated by PHPUnit_Util_Skeleton on 2007-03-21 at 16:49:21.
 */
class USVN_Config_IniTest extends USVN_Test_Test {
	private $config;

    /**
     * Runs the test methods of this class.
     *
     * @access public
     * @static
     */
    public static function main() {
        require_once "PHPUnit/TextUI/TestRunner.php";

        $suite  = new PHPUnit_Framework_TestSuite("USVN_Config_IniTest");
        $result = PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function setUp() {
		parent::setUp();
		file_put_contents("tests/tmp/test.ini",'[global]
test1 = "Test 1"
test2.value = "Test 2"
test2.key = "Test key 2"
test3.subvalue.value = "Test 3"
test4 = "Test 4"
		');
		$this->config = new USVN_Config_Ini("tests/tmp/test.ini", "global");
    }

    public function tearDown() {
		unlink("tests/tmp/test.ini");
		if (file_exists("tests/tmp/test2.ini")) {
			unlink("tests/tmp/test2.ini");
		}
		parent::tearDown();
    }

    public function testSaveNoChange() {
		$this->test1 = "Test 1 Modif";
		$this->config->save();
		$config2 = new Zend_Config_Ini("tests/tmp/test.ini", "global");
		$this->assertEquals("Test 1", $config2->test1);
		$this->assertEquals("Test 2", $config2->test2->value);
		$this->assertEquals("Test key 2", $config2->test2->key);
		$this->assertEquals("Test 3", $config2->test3->subvalue->value);
		$this->assertEquals("Test 4", $config2->test4);
    }

    public function testSave() {
		$this->config->test1 = "Test 1 Modif";
		$this->assertEquals("Test 1 Modif", $this->config->test1);
		$this->config->save();
		$config2 = new Zend_Config_Ini("tests/tmp/test.ini", "global");
		$this->assertEquals("Test 1 Modif", $config2->test1);
		$this->assertEquals("Test 1 Modif", $config2->test1);
    }

	public function testCreate() {
		$config = new USVN_Config_Ini("tests/tmp/test2.ini", "global", array("create" => true));
		$this->assertFileExists("tests/tmp/test2.ini");
		$config->test = array("valeur" => "tutu");
		$config->save();
		$config2 = new Zend_Config_Ini("tests/tmp/test2.ini", "global");
		$this->assertEquals("tutu", $config2->test->valeur);
	}

	public function testNotCreate() {
		try {
			$config = new USVN_Config_Ini("tests/tmp/test2.ini", "global");
		}
		catch (Exception $e) {
			$this->assertFileNotExists("tests/tmp/test2.ini");
			return;
		}
		$this->fail();
	}

	public function testCreateNotPossible() {
		try {
			$config = new USVN_Config_Ini("tests/fake/test2.ini", "global", array("create" => true));
		}
		catch (Exception $e) {
			return;
		}
		$this->fail();
	}
}

// Call USVN_Config_IniTest::main() if this source file is executed directly.
if (PHPUnit_MAIN_METHOD == "USVN_Config_IniTest::main") {
    USVN_Config_IniTest::main();
}
?>
