<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tab_Payment_Method
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.de/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Netresearch_Magebid_Block_Adminhtml_Export_Edit_Tab_Payment_Method extends Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Payment_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_element = null;
    protected $_paymentMethods = null;
    protected $_websites = null;
}
?>