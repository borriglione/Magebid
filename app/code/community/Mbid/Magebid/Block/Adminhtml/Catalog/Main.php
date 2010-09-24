<?php
/**
 * Mbid_Magebid_Block_Adminhtml_Catalog_Main
 *
 * @category  Mbid
 * @package   Mbid_Magebid
 * @author    André Herrn <info@magebid.com>
 * @copyright 2010 André Herrn | Netresearch GmbH & Co.KG (http://www.netresearch.de)
 * @link      http://www.magebid.com/
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*/
class Mbid_Magebid_Block_Adminhtml_Catalog_Main extends Mage_Adminhtml_Block_Catalog_Product
{
	
    /**
     * Prepare Layout
     *
     * @return void
     */	  
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate('magebid/catalog/product.phtml');
        $this->setChild('grid', $this->getLayout()->createBlock('magebid/adminhtml_catalog_product_grid'));
    }
}
?>