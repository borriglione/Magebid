<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Configuration_Edit_Form
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Configuration_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Initialize form
     *
     * @return object
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
