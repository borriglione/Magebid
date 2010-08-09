<?php
class Netresearch_Magebid_Block_Adminhtml_Auction_Main_Grid_Renderer_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
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
