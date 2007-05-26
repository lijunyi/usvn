<?php
/**
 * Reinstall database
 *
 * @author Team USVN <contact@usvn.info>
 * @link http://www.usvn.info
 * @license http://www.cecill.info/licences/Licence_CeCILL_V2-en.txt CeCILL V2
 * @copyright Copyright 2007, Team USVN
 * @since 0.5
 * @package utils
 *
 * This software has been written at EPITECH <http://www.epitech.net>
 * EPITECH, European Institute of Technology, Paris - FRANCE -
 * This project has been realised as part of
 * end of studies project.
 *
 * $Id$
 */

require_once('www/USVN/autoload.php');

USVN_Translation::initTranslation('en_US', 'www/locale');
$config = new USVN_Config_Ini("www/config.ini", "general");
Zend_Registry::set('config', $config);

$db = Zend_Db::factory($config->database->adapterName, $config->database->options->asArray());
USVN_Db_Table::$prefix = $config->database->prefix;
Zend_Db_Table::setDefaultAdapter($db);
USVN_Db_Utils::deleteAllTables($db);
unlink("www/config.ini");
unlink("www/.htaccess");
USVN_DirectoryUtils::removeDirectory("www/files");
`svn up www/files`;