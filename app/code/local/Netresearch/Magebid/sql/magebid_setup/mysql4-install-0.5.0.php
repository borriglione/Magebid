<?php

$installer = $this;

$installer->startSetup();
$installer->run("

CREATE TABLE IF NOT EXISTS `magebid_auction` (
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

CREATE TABLE IF NOT EXISTS `magebid_auction_detail` (
  `magebid_auction_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `life_time` int(11) DEFAULT NULL,
  `start_price` decimal(11,2) DEFAULT NULL,
  `fixed_price` decimal(11,2) DEFAULT NULL,
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
  PRIMARY KEY (`magebid_auction_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_auction_type` (
  `magebid_auction_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`magebid_auction_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `magebid_auction_type` (`magebid_auction_type_id`, `name`) VALUES
(1, 'Auction / Chinese'),
(2, 'FixedPriceItem');

CREATE TABLE IF NOT EXISTS `magebid_configuration` (
  `magebid_configuration_id` int(1) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`magebid_configuration_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `magebid_ebay_status` (
  `magebid_ebay_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`magebid_ebay_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `magebid_ebay_status` (`magebid_ebay_status_id`, `status_name`) VALUES
(0, 'Noch nicht eingestellt'),
(1, 'In Vorbereitung'),
(2, 'Aktiv'),
(3, 'Beendet');

CREATE TABLE IF NOT EXISTS `magebid_import_category` (
  `magebid_import_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `category_level` int(11) NOT NULL,
  `category_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `category_parent_id` int(11) NOT NULL,
  `store` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`magebid_import_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_import_payment_methods` (
  `magebid_import_payment_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`magebid_import_payment_methods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_import_return_policy` (
  `magebid_import_return_policy_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `value` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`magebid_import_return_policy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_import_shipping_methods` (
  `magebid_import_shipping_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `shipping_service` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `shipping_service_id` int(11) DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `carrier` varchar(255) DEFAULT NULL,
  `international` int(1) DEFAULT NULL,
  `mapped_shipping_service` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`magebid_import_shipping_methods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_listing_enhancement` (
  `magebid_listing_enhancement_id` int(11) NOT NULL AUTO_INCREMENT,
  `magebid_profile_id` int(111) DEFAULT NULL,
  `magebid_auction_id` int(11) DEFAULT NULL,
  `code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`magebid_listing_enhancement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_mapping` (
  `magebid_mapping_id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(255) CHARACTER SET latin1 NOT NULL,
  `magento` varchar(255) CHARACTER SET latin1 NOT NULL,
  `ebay` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`magebid_mapping_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_payment_methods` (
  `magebid_payment_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `magebid_profile_id` int(11) DEFAULT NULL,
  `magebid_auction_id` int(11) DEFAULT NULL,
  `magebid_transaction_id` int(11) NOT NULL,
  `code` varchar(255) CHARACTER SET latin1 NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY (`magebid_payment_methods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_profile` (
  `magebid_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(255) NOT NULL,
  `start_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `fixed_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `duration` int(11) NOT NULL DEFAULT '0',
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
  PRIMARY KEY (`magebid_profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_shipping_methods` (
  `magebid_shipping_methods_id` int(11) NOT NULL AUTO_INCREMENT,
  `magebid_profile_id` int(11) DEFAULT NULL,
  `magebid_auction_id` int(11) DEFAULT NULL,
  `magebid_transaction_id` int(11) DEFAULT NULL,
  `code` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `price` decimal(11,2) DEFAULT NULL,
  `add_price` decimal(11,2) NOT NULL,
  PRIMARY KEY (`magebid_shipping_methods_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_templates` (
  `magebid_templates_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_name` varchar(255) NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `content_type` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`magebid_templates_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_transaction` (
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
  PRIMARY KEY (`magebid_transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `magebid_transaction_user` (
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

");

$installer->endSetup(); 