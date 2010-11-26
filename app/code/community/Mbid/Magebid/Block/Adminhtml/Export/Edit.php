<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Export_Edit
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Export_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Construct
     *
     * @return void
     */
	public function __construct()
    {
        parent::__construct();

        $this->_blockGroup = 'magebid';
        $this->_mode = 'edit';
        $this->_controller = 'adminhtml_export';

		$this->_updateButton('save', 'label', Mage::helper('magebid')->__('Prepare'));
		$this->_removeButton('back');
		$this->_removeButton('reset');
    }

    /**
     * Return Header Text
     *
     * @return string
     */
    public function getHeaderText()
    {
		return Mage::helper('magebid')->__('Magebid Export (Profile: %s)',Mage::getModel('magebid/profile')->load(Mage::registry('profile_id'))->getProfileName());
    }
}
