<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "databaseconnectionscanner".
 *
 * Auto generated 31-08-2016 18:23
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'DatabaseConnectionScanner',
  'description' => 'Find usages of DatabaseConnection class',
  'category' => 'module',
  'author' => 'Nicole Cordes',
  'author_email' => 'typo3@cordes.co',
  'author_company' => 'CPS-IT GmbH',
  'state' => 'stable',
  'uploadfolder' => 0,
  'createDirs' => '',
  'clearCacheOnLoad' => 1,
  'version' => '0.1.0',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '8.0.0-8.3.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'autoload' =>
  array (
    'psr-4' =>
    array (
      'IchHabRecht\\Databaseconnectionscanner\\' => 'Classes/',
    ),
  ),
  '_md5_values_when_last_written' => 'a:1:{s:12:"ext_icon.png";s:4:"c236";}',
);

