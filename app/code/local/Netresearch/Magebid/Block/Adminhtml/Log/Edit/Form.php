<?php
/**
 * Netresearch_Magebid_Block_Adminhtml_Log_Edit_Form
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Block_Adminhtml_Log_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));
        
        $log_data = Mage::registry('frozen_magebid')->getData();

        $fieldset = $form->addFieldset('edit_magebid', array('legend' => Mage::helper('magebid')->__('Log')));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'title'     => Mage::helper('magebid')->__('Title'),
            'label'     => Mage::helper('magebid')->__('Title'),
            'maxlength' => '50',
			'style'		=> 'width:98%;',
            'required'  => true,
        ));		       
		
        $fieldset->addField('type', 'text', array(
            'name'      => 'type',
            'title'     => Mage::helper('magebid')->__('Type'),
            'label'     => Mage::helper('magebid')->__('Type'),
            'maxlength' => '50',
			'style'		=> 'width:98%;',
            'required'  => true,
        ));	
        
        $fieldset->addField('result', 'text', array(
            'name'      => 'result',
            'title'     => Mage::helper('magebid')->__('Result'),
            'label'     => Mage::helper('magebid')->__('Result'),
            'maxlength' => '50',
			'style'		=> 'width:98%;',
            'required'  => true,
        ));	  
        
        $outputFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        $fieldset->addField('date_created', 'date', array(
            'name'      => 'date_created',
            'title'     => Mage::helper('magebid')->__('Date'),
            'label'     => Mage::helper('magebid')->__('Date'),
            'format'    => $outputFormat,
            'maxlength' => '50',
 			'style'		=> 'width:98%;',       
            'required'  => true,
        ));	       
 
  
        $fieldset->addField('request', 'textarea', array(
            'name'      => 'request',
            'title'     => Mage::helper('magebid')->__('Request'),
            'label'     => Mage::helper('magebid')->__('Request'),
            'style'     => 'width: 700px; height: 400px;',
            'required'  => true,
        ));		
        
         $fieldset->addField('response', 'textarea', array(
            'name'      => 'response',
            'title'     => Mage::helper('magebid')->__('Response'),
            'label'     => Mage::helper('magebid')->__('Response'),
            'style'     => 'width: 700px; height: 400px;',
            'required'  => true,
        ));		

        $fieldset->addField('additional', 'textarea', array(
            'name'      => 'additional',
            'title'     => Mage::helper('magebid')->__('Additional'),
            'label'     => Mage::helper('magebid')->__('Additional'),
            'style'     => 'width: 700px; height: 400px;',
            'required'  => true,
        ));		

        $form->setValues(Mage::registry('frozen_magebid')->getData());
        
        if ($log_data['date_created']!="") $form->getElement('date_created')->setValue(
                Mage::app()->getLocale()->date($log_data['date_created'], Varien_Date::DATETIME_INTERNAL_FORMAT)
        );       
                
        // $form->setUseContainer(true);       
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
