<?php
class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Tab_Daily_log extends Mage_Adminhtml_Block_Widget_Form
{	
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('magebid/configuration/tab/daily/log.phtml');
        $this->setTitle('Return Policy');
    }
	
    public function getHeaderText()
    {
        return Mage::helper('magebid')
          ->__("Daily Log");
    }	
    
    public function _beforeToHtml()
    {		
		$this->setChild('grid', $this->getLayout()->createBlock('magebid/adminhtml_configuration_edit_tab_daily_log_grid', 'configuration.daily.log.grid'));
        return parent::_beforeToHtml();
    }	    
}
?>
