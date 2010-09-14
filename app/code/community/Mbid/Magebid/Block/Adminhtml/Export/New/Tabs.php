<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Export_New_Tabs
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Export_New_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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