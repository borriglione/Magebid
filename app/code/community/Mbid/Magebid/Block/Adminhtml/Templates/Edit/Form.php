<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Templates_Edit_Form
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Templates_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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

        $fieldset = $form->addFieldset('edit_magebid', array('legend' => Mage::helper('magebid')->__('Template')));

        $fieldset->addField('content_name', 'text', array(
            'name'      => 'content_name',
            'title'     => Mage::helper('magebid')->__('Title'),
            'label'     => Mage::helper('magebid')->__('Title'),
            'maxlength' => '50',
			'style'		=> 'width:98%;',
            'required'  => true,
        ));	
		
        $fieldset->addField('content_type', 'select', array(
            'name'      => 'content_type',
            'title'     => Mage::helper('magebid')->__('Type'),
            'label'     => Mage::helper('magebid')->__('Type'),
			'values'	=> Mage::getModel('magebid/templates')->getTemplateTypes(),		
			'style'		=> 'width:100%;',
            'required'  => true,
        ));					

        $fieldset->addField('content', 'textarea', array(
            'name'      => 'content',
            'title'     => Mage::helper('magebid')->__('Content'),
            'label'     => Mage::helper('magebid')->__('Content'),
            'style'     => 'width: 700px; height: 400px;',
            'required'  => true,
        ));

        $form->setUseContainer(true);
        $form->setValues(Mage::registry('frozen_magebid')->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
?>