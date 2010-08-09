<?php
class Netresearch_Magebid_Block_Adminhtml_Auction_Edit_Tab_Description extends Mage_Adminhtml_Block_Widget_Form
{	
	protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
		$allowEdit = $this->getAllowEdit();
		if ($allowEdit) $disabled = false; else $disabled = true;
		
        $form->setHtmlIdPrefix('auction_');
		
		$store = Mage::app()->getStore();

        $auction = $form->addFieldset('auction_form', array('legend'=>Mage::helper('magebid')->__('Description')));
	   
        $auction->addField('auction_description', 'textarea', array(
            'name'      => 'auction_description',
            'title'     => Mage::helper('magebid')->__('Description'),
            'label'     => Mage::helper('magebid')->__('Description'),
            'style'     => 'width: 400px; height: 600px;',
            'required'  => true,
			'disabled' => $disabled,	
        ));

       
				
        //$form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();	
	}
	
	public function getAllowEdit()
	{
		$role = Mage::registry('role');
		if ($role=='view') return false;
		return true;
	}			
}
?>
