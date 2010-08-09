<?php

class Netresearch_Magebid_Block_Adminhtml_Configuration_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Initialize cache management form
     *
     * @return Mage_Adminhtml_Block_System_Cache_Form
     */
    public function initForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'configuration_form',
            'action'    => $this->getUrl('*/*/save'),
            'method'    => 'post',
			'name' 		=> 'configuration_form',
        ));
		$form->setUseContainer(true);
		
        $form->addField('task_action', 'hidden', array(
            'name'      => 'task_action',
        ));	
		
        $this->setForm($form);
        return $this;
    }
}
