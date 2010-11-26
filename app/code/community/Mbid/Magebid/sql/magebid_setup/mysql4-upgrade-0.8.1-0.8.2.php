<?php
/**
 * Netresearch MySql-Update from Version 0.8.0 to 0.8.1
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    Andreas Plieninger <info@plieninger.org>
 * @copyright 2010 Andreas Plieninger
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/

$installer = $this;

$installer->startSetup();
$installer->run("
ALTER TABLE `magebid_transaction` ADD ADD `reservation_quantity` INT NOT NULL ;
ALTER TABLE `magebid_auction_detail` ADD `ebay_sku` VARCHAR( 50 ) NOT NULL ;
ALTER TABLE `magebid_transaction` ADD `order_shipping_cost` DECIMAL( 11, 2 ) NOT NULL ;
");

$installer->endSetup();
