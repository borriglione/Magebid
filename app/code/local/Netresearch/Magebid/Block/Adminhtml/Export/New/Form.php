<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Export_New_Form
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Export_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare Form
     *
     * @return object
     */	
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/massPrepare'),
            'method'    => 'post'
        ));	
		
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();       
    }
}
