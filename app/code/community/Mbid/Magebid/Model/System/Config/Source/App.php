<?php
/**
 * Mbid_Magebid_Model_System_Config_Source_App
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Model_System_Config_Source_App
{	
    /**
     * Return the option sandbox and production for the magebid system configuration area
     *
     * @return array
     */	
	public function toOptionArray()
    {
    	$app_mode_array = array();
		
		$app_mode_array[] = array('value'=>1,'label'=>Mage::helper('magebid')->__('Sandbox'));
		$app_mode_array[] = array('value'=>0,'label'=>Mage::helper('magebid')->__('Production'));
		
		array_unshift($app_mode_array, array('value'=>'', 'label'=> Mage::helper('adminhtml')->__('--Please Select--')));
		
		return $app_mode_array;		
    }
}
?>