<?php
/**
 * Netresearch MySql-Update from Version 0.8.11 to 0.8.12
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
ALTER TABLE `magebid_import_category` CHANGE `category_id` `category_id` BIGINT( 18 ) NOT NULL;
ALTER TABLE `magebid_import_category` CHANGE `category_parent_id` `category_parent_id` BIGINT( 18 ) NOT NULL;
ALTER TABLE `magebid_import_category_features` CHANGE `category_id` `category_id` BIGINT( 18 ) NOT NULL;
ALTER TABLE `magebid_auction_detail` CHANGE `ebay_category_1` `ebay_category_1` BIGINT( 18 ) NULL DEFAULT NULL;
ALTER TABLE `magebid_auction_detail` CHANGE `ebay_category_2` `ebay_category_2` BIGINT( 18 ) NULL DEFAULT NULL;
ALTER TABLE `magebid_auction_detail` CHANGE `ebay_store_category_1` `ebay_store_category_1` BIGINT( 18 ) NULL DEFAULT NULL;
ALTER TABLE `magebid_auction_detail` CHANGE `ebay_store_category_2` `ebay_store_category_2` BIGINT( 18 ) NULL DEFAULT NULL;
ALTER TABLE `magebid_profile` CHANGE `ebay_category_1` `ebay_category_1` BIGINT( 18 ) NULL DEFAULT NULL;
ALTER TABLE `magebid_profile` CHANGE `ebay_category_2` `ebay_category_2` BIGINT( 18 ) NULL DEFAULT NULL;
ALTER TABLE `magebid_profile` CHANGE `ebay_store_category_1` `ebay_store_category_1` BIGINT( 18 ) NULL DEFAULT NULL;
ALTER TABLE `magebid_profile` CHANGE `ebay_store_category_2` `ebay_store_category_2` BIGINT( 18 ) NULL DEFAULT NULL;

");

$installer->endSetup(); 