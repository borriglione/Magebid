<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Profile_Edit_Tab_Payment_Method
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Profile_Edit_Tab_Payment_Method extends Mbid_Magebid_Block_Adminhtml_Auction_Edit_Tab_Payment_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_element = null;
    protected $_paymentMethods = null;
    protected $_websites = null;
}
?>