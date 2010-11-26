<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Auction_Main_Grid_Renderer_Action
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Auction_Main_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * Return Popup-Link for eBay-Description-Preview and eBay-Auction-Link
     *
     * @return string
     */	
    public function render(Varien_Object $row)
    {
        $rendered_link = "";
		$preview_link = $this->getUrl('*/*/previewEbayDescription', array('_current'=>true,'id'=>$row->getId()));
		if ($row->getLink()!="") $rendered_link = '<a href="#" onclick="Popup.open({url:\''.$row->getLink().'\'})">'.Mage::helper('magebid')->__('eBay').'</a> / ';
		$rendered_link .= '<a href="#" onclick="Popup.open({url:\''.$preview_link.'\'})"> '.Mage::helper('magebid')->__('Preview').'</a><br />';
		return $rendered_link;
    }
}
?>
