<?php
/**
 * Netresearch MySql-Update from Version 0.8.0 to 0.8.1
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

$installer = $this;

$installer->startSetup();
$installer->run("
ALTER TABLE {$installer->getTable('magebid/auction_detail')} CHANGE `life_time` `listing_duration` VARCHAR( 255 ) NULL DEFAULT NULL;
ALTER TABLE {$installer->getTable('magebid/profile')} CHANGE `duration` `listing_duration` VARCHAR( 255 ) NULL DEFAULT NULL;
TRUNCATE TABLE {$installer->getTable('magebid/profile')};");
$installer->endSetup(); 