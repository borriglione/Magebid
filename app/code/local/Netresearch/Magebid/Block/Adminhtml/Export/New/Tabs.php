<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_New_Tabs
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Export_New_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Construct
     *
     * @return void
     */	
    public function __construct()
    {
        parent::__construct();		
        $this->setId('magebid_export_new_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('magebid')->__('Profile'));
    }

    /**
     * Before HTML
     *
     * @return object
     */	
    protected function _beforeToHtml()
    {
        $this->addTab('profile', array(
            'label'     => Mage::helper('magebid')->__('Profile'),
            'title'     => Mage::helper('magebid')->__('Profile'),
            'content'   => $this->getLayout()->createBlock('magebid/adminhtml_export_new_tab_profile')->toHtml(),
            'active'    => true,
        ));

        return parent::_beforeToHtml();
    }
}