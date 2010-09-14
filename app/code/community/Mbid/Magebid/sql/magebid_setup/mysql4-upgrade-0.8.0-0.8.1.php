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
ALTER TABLE `magebid_auction_detail` CHANGE `life_time` `listing_duration` VARCHAR( 255 ) NULL DEFAULT NULL;
ALTER TABLE `magebid_profile` CHANGE `duration` `listing_duration` VARCHAR( 255 ) NULL DEFAULT NULL;
TRUNCATE TABLE `magebid_profile`; 
INSERT INTO `magebid_profile` (`magebid_profile_id`, `profile_name`, `start_price`, `fixed_price`, `listing_duration`, `quantity`, `country`, `currency`, `location`, `dispatch_time`, `ebay_category_1`, `ebay_category_2`, `ebay_store_category_1`, `ebay_store_category_2`, `is_image`, `is_more_images`, `is_galery_image`, `magebid_auction_type_id`, `hit_counter`, `header_templates_id`, `main_templates_id`, `footer_templates_id`, `refund_option`, `returns_accepted_option`, `returns_within_option`, `returns_description`, `use_tax_table`, `vat_percent`, `condition_id`) VALUES
(1, 'Default', '-10%', '+20%', 'Days_7', 10, 'DE', 'EUR', 'Leipzig', 1, 9355, 12395, 0, 0, 1, 0, 1, 2, 'RetroStyle', 1, 3, 2, 'MoneyBack', 'ReturnsAccepted', 14, 'Information zum Rückgaberecht.', 0, 1.000, 1000);

");

$installer->endSetup(); 