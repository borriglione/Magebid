<?php
/**
 * Mbid_Magebid_Adminhtml_Templates_MainController
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Adminhtml_Catalog_MainController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Main/Grid View
     *
     * @return void
     */	 
	public function indexAction()
    {
        $this->loadLayout()
           ->_addContent($this->getLayout()
                           ->createBlock('magebid/adminhtml_catalog_main'))
            ->renderLayout();			
    }
    
    /**
     * Product grid-load for the ajax request
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magebid/adminhtml_catalog_product_grid')->toHtml()
        );
    }
}
?>