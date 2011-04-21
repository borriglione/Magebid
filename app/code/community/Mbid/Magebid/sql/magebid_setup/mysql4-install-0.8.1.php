<?php
/**
 * Netresearch MySql-Installer
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

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/auction')}` (
  `magebid_auction_id` int(11) NOT NULL AUTO_INCREMENT,
  `magebid_auction_detail_id` int(11) NOT NULL,
  `ebay_item_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `magebid_ebay_status_id` int(11) DEFAULT NULL,
  `magebid_auction_type_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`magebid_auction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/auction_detail')}` (
  `magebid_auction_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `listing_duration` varchar(255) DEFAULT NULL,
  `start_price` varchar(255) DEFAULT NULL,
  `fixed_price` varchar(255) DEFAULT NULL,
  `price_now` decimal(11,2) DEFAULT NULL,
  `final_price` decimal(11,2) DEFAULT NULL,
  `auction_name` varchar(255) DEFAULT NULL,
  `auction_description` text,
  `quantity` int(11) DEFAULT NULL,
  `quantity_sold` int(11) DEFAULT NULL,
  `is_image` int(1) DEFAULT NULL,
  `is_more_images` int(1) DEFAULT NULL,
  `is_galery_image` int(1) DEFAULT NULL,
  `ebay_category_1` int(11) DEFAULT NULL,
  `ebay_category_2` int(11) DEFAULT NULL,
  `ebay_store_category_1` int(11) NOT NULL DEFAULT '0',
  `ebay_store_category_2` int(11) NOT NULL DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `dispatch_time` int(11) DEFAULT NULL,
  `hit_counter` varchar(255) DEFAULT NULL,
  `refund_option` varchar(255) DEFAULT NULL,
  `returns_accepted_option` varchar(255) DEFAULT NULL,
  `returns_within_option` int(11) DEFAULT NULL,
  `returns_description` text,
  `last_updated` datetime DEFAULT NULL,
  `use_tax_table` tinyint(1) NOT NULL DEFAULT '0',
  `vat_percent` decimal(11,3) DEFAULT NULL,
  `condition_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`magebid_auction_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/auction_type')}` (
  `magebid_auction_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`magebid_auction_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/configuration')}` (
  `magebid_configuration_id` int(1) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`magebid_configuration_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/import_category')}` (
  `magebid_import_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `category_level` int(11) NOT NULL,
  `category_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `category_parent_id` int(11) NOT NULL,
  `condition_enabled` tinyint(1) DEFAULT NULL,
  `store` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`magebid_import_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/import_category_features')}` (
  `magebid_import_category_features_id` int(11) NOT NULL AUTO_INCREMENT,
  `key_id` varchar(255) NOT NULL,
  `value_id` int(11) NOT NULL,
  `value_display_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`magebid_import_category_features_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/import_payment')}` (
  `magebid_import_payment_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`magebid_import_payment_methods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/import_policy')}` (
  `magebid_import_return_policy_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`magebid_import_return_policy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/import_shipping')}` (
  `magebid_import_shipping_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_service` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `shipping_service_id` int(11) DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `carrier` varchar(255) DEFAULT NULL,
  `international` int(1) DEFAULT NULL,
  `mapped_shipping_service` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`magebid_import_shipping_methods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/listing_enhancement')}` (
  `magebid_listing_enhancement_id` int(11) NOT NULL AUTO_INCREMENT,
  `magebid_profile_id` int(111) DEFAULT NULL,
  `magebid_auction_id` int(11) DEFAULT NULL,
  `code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`magebid_listing_enhancement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid_mapping')}` (
  `magebid_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(255) CHARACTER SET latin1 NOT NULL,
  `magento` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ebay` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`magebid_mapping_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/payments')}` (
  `magebid_payment_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `magebid_profile_id` int(11) DEFAULT NULL,
  `magebid_auction_id` int(11) DEFAULT NULL,
  `magebid_transaction_id` int(11) NOT NULL,
  `code` varchar(255) CHARACTER SET latin1 NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY (`magebid_payment_methods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/profile')}` (
  `magebid_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(255) NOT NULL,
  `start_price` varchar(255) DEFAULT NULL,
  `fixed_price` varchar(255) DEFAULT NULL,
  `listing_duration` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `country` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `dispatch_time` int(11) NOT NULL,
  `ebay_category_1` int(11) DEFAULT '0',
  `ebay_category_2` int(11) DEFAULT '0',
  `ebay_store_category_1` int(11) NOT NULL DEFAULT '0',
  `ebay_store_category_2` int(11) NOT NULL DEFAULT '0',
  `is_image` tinyint(1) NOT NULL DEFAULT '0',
  `is_more_images` tinyint(1) NOT NULL DEFAULT '0',
  `is_galery_image` tinyint(1) NOT NULL DEFAULT '0',
  `magebid_auction_type_id` int(11) DEFAULT NULL,
  `hit_counter` varchar(255) DEFAULT NULL,
  `header_templates_id` int(11) DEFAULT NULL,
  `main_templates_id` int(11) DEFAULT NULL,
  `footer_templates_id` int(11) DEFAULT NULL,
  `refund_option` varchar(255) DEFAULT NULL,
  `returns_accepted_option` varchar(255) DEFAULT NULL,
  `returns_within_option` int(11) DEFAULT NULL,
  `returns_description` text,
  `use_tax_table` tinyint(1) NOT NULL DEFAULT '0',
  `vat_percent` decimal(11,3) DEFAULT NULL,
  `condition_id` int(11) DEFAULT NULL,  
  PRIMARY KEY (`magebid_profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/shipping')}` (
  `magebid_shipping_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `magebid_profile_id` int(11) DEFAULT NULL,
  `magebid_auction_id` int(11) DEFAULT NULL,
  `magebid_transaction_id` int(11) DEFAULT NULL,
  `code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `add_price` decimal(11,2) NOT NULL,
  PRIMARY KEY (`magebid_shipping_methods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/templates')}` (
  `magebid_templates_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_name` varchar(255) NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`magebid_templates_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/transaction')}` (
  `magebid_transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `ebay_item_id` varchar(20) DEFAULT NULL,
  `ebay_transaction_id` varchar(20) DEFAULT NULL,
  `auction_title` varchar(255) DEFAULT NULL,
  `total_amount` decimal(11,2) DEFAULT NULL,
  `single_price` decimal(11,2) DEFAULT NULL,
  `tax_included` int(1) NOT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `buyer_ebay_user_id` varchar(255) DEFAULT NULL,
  `checkout_status` varchar(255) NOT NULL,
  `complete_status` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_hold_status` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `shipping_method` varchar(255) DEFAULT NULL,
  `shipping_cost` decimal(11,2) DEFAULT NULL,
  `shipping_add_cost` decimal(11,2) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_created` tinyint(1) NOT NULL,
  `payment_received` int(1) NOT NULL DEFAULT '0',
  `shipped` int(1) NOT NULL DEFAULT '0',
  `reviewed` int(1) NOT NULL DEFAULT '0',
  `ebay_order_id` varchar(255) DEFAULT NULL,
  `ebay_order_status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`magebid_transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/transaction_user')}` (
  `magebid_transaction_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_email` varchar(255) DEFAULT NULL,
  `registration_name` varchar(255) DEFAULT NULL,
  `registration_street` varchar(255) DEFAULT NULL,
  `registration_street_add` varchar(255) DEFAULT NULL,
  `registration_city` varchar(255) DEFAULT NULL,
  `registration_zip_code` varchar(255) DEFAULT NULL,
  `registration_country` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_street` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_zip_code` varchar(255) DEFAULT NULL,
  `shipping_country` varchar(255) DEFAULT NULL,
  `magebid_transaction_id` int(11) NOT NULL,
  PRIMARY KEY (`magebid_transaction_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/daily_log')}` (
  `magebid_daily_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`magebid_daily_log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('magebid/log')}` (
  `magebid_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `request` text NOT NULL,
  `response` text NOT NULL,
  `additional` text NOT NULL,
  `result` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`magebid_log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `{$installer->getTable('magebid/auction_type')}` (`magebid_auction_type_id`, `name`) VALUES
(1, 'Auction / Chinese'),
(2, 'FixedPriceItem');

INSERT INTO `{$installer->getTable('magebid/templates')}` (`magebid_templates_id`, `content_name`, `content`, `content_type`, `date_created`, `date_modified`) VALUES
(1, 'Default', '<div id=\"magebid_store_header\">\r\n<link href=\"{{skin_url}}/frontend/default/default/css/magebid/default/default.css\" type=\"text/css\" rel=\"stylesheet\">\r\n<script type=\"text/javascript\">\r\n<!--\r\nfunction zoom_image(source)\r\n{\r\nif (source.indexOf(''{{var'')>-1) return false;\r\nvar big_image;\r\nbig_image = document.getElementById(\"magebid_main_image\").getElementsByTagName(\"img\")[0].src = source;\r\n}\r\n-->\r\n</script>	\r\n</div>', 'header', '2010-08-27 13:33:48', '2010-08-27 17:21:22'),
(2, 'Default', '<div id=\"magebid_store_footer\">\r\n<img src=\"{{skin_url}}frontend/default/default/images/magebid/default/footer.gif\">\r\n<ul class=\"magebid_info_list\">\r\n<li><a href=\"{{link_url}}\">Home</a></li>\r\n<li><a href=\"{{link_url}}\">Kontakt</a></li>\r\n<li><a href=\"{{link_url}}\">Impressum</a></li>\r\n<li><a href=\"{{link_url}}\">Datenschutz</a></li>\r\n<li><a href=\"{{link_url}}\">Nutzungsbedingungen</a></li>\r\n</ul>\r\n</div>', 'footer', '2010-08-27 13:34:13', '2010-08-27 16:15:01'),
(3, 'Default', '<div id=\"magebid_store_main\">\r\n<table>\r\n<tr>\r\n<td>\r\n<div id=\"magebid_main_image\">\r\n{{var product_image1}}<br />\r\n</div>\r\n<div id=\"magebid_list_images\">\r\n<a href=#\" onclick=\"javascript:zoom_image(''{{var link_product_image1}}'');return false;\">{{var product_image1}}</a>\r\n<a href=#\" onclick=\"javascript:zoom_image(''{{var link_product_image2}}'');return false;\">{{var product_image2}}</a>\r\n<a href=#\" onclick=\"javascript:zoom_image(''{{var link_product_image3}}'');return false;\">{{var product_image3}}</a>\r\n</div>\r\n</td>\r\n<td class=\"magebid_description\">\r\n<h1>{{var product_name}}</h1>\r\n<p class=\"short_desc\">{{var product_short_description}}</p>\r\n<p class=\"long_desc\">{{var product_description}}</p>\r\n<!-- Beliebige Attribute\r\n<ul>\r\n <li class=\"dimension\">Größe: {{var product_dimension}}</li>\r\n <li class=\"dimension\">Hersteller: {{var product_manufacturer}}</li>\r\n <li class=\"dimension\">Farbe: {{var product_color}}</li>\r\n</ul>\r\n-->\r\n</td>\r\n</tr>\r\n</table>\r\n</div>', 'main', '2010-08-27 13:35:00', '2010-08-27 17:13:52');

");

$installer->endSetup(); 