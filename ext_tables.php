<?php
defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['databaseconnectionscanner']['databaseconnection'] = [
        'title' => 'LLL:EXT:databaseconnectionscanner/Resources/Private/Language/locallang_be.xlf:report_title',
        'description' => 'LLL:EXT:databaseconnectionscanner/Resources/Private/Language/locallang_be.xlf:report_description',
        'icon' => 'EXT:databaseconnectionscanner/ext_icon.png',
        'report' => IchHabRecht\Databaseconnectionscanner\Report\DatabaseConnectionListReport::class,
    ];
}
