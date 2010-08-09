<?php
class Netresearch_Magebid_Block_Adminhtml_Export_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'magebid';		
        $this->_mode = 'edit';
        $this->_controller = 'adminhtml_export';

		$profile_id = Mage::registry('profile_id');		
		
        if( $profile_id>0 )
		{
            $magebidData = Mage::getModel('magebid/profile')->load($profile_id);
            Mage::register('frozen_magebid', $magebidData);
		}
		
		$this->_updateButton('save', 'label', Mage::helper('magebid')->__('Prepare'));	
		$this->_removeButton('back');
		$this->_removeButton('reset');
    }

    public function getHeaderText()
    {
		return Mage::helper('magebid')->__('Magebid Export (Profile: %s)',Mage::getModel('magebid/profile')->load(Mage::registry('profile_id'))->getProfileName());
    }
}
