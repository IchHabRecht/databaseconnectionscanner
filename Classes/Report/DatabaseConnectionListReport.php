<?php
namespace IchHabRecht\Databaseconnectionscanner\Report;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Nicole Cordes <cordes@cps-it.de>, CPS-IT GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Symfony\Component\Finder\Finder;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Package\Package;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Dbal\Database\DatabaseConnection as DbalDatabaseConnection;
use TYPO3\CMS\Reports\ReportInterface;

class DatabaseConnectionListReport implements ReportInterface
{
    /**
     * Returns the content for the report
     *
     * @return string
     */
    public function getReport()
    {
        $packages = $this->getSortedPackages();

        $content = '';
        /** @var Package $package */
        foreach ($packages as $package) {
            $packagePath = rtrim($package->getPackagePath(), '/');
            $finder = new Finder();
            $finder
                ->files()
                ->name('*.php')
                ->in($packagePath)
                ->contains('$GLOBALS[\'TYPO3_DB\']')
                ->contains(DatabaseConnection::class)
                ->contains(DbalDatabaseConnection::class);

            $files = iterator_to_array($finder);
            if (empty($files)) {
                continue;
            }

            $content .= '<h2>EXT:' . $package->getPackageKey() . '</h2>';
            $content .= '<table class="table table-striped table-hover">';
            $content .= '<tbody>';
            foreach ($files as $file) {
                $content .= '
                    <tr>
                        <td class="col-xs-12">' . PathUtility::getRelativePath($packagePath, $file->getPath()) . $file->getFileName() . '</td>
                    </tr>';
            }
            $content .= '</tbody>';
            $content .= '</table>';
        }

        return $content;
    }

    /**
     * @return array
     */
    protected function getSortedPackages()
    {
        $packageManager = Bootstrap::getInstance()->getEarlyInstance(PackageManager::class);
        $packages = $packageManager->getAvailablePackages();

        usort($packages, function (Package $a, Package $b) {
            $isASysExt = 'typo3-cms-framework' === $a->getValueFromComposerManifest('type');
            $isBSysExt = 'typo3-cms-framework' === $b->getValueFromComposerManifest('type');
            if ($isASysExt && $isBSysExt || !$isASysExt && !$isBSysExt) {
                return strcmp($a->getPackageKey(), $b->getPackageKey());
            } elseif ($isASysExt) {
                return -1;
            }

            return 1;
        });

        return $packages;
    }
}
