<?php
/**
 * Netresearch_Magebid_Model_Template_Renderer
 *
 * @category  Netresearch
 * @package   Netresearch_Magebid
 * @author    André Herrn <andre.herrn@netresearch.de>
 * @copyright 2010 André Herrn
 * @link      http://www.magebid.de/
*/
class Netresearch_Magebid_Model_Template_Renderer extends Mage_Core_Model_Abstract
{	
    /**
     * Product
     * @var Mage_Catalog_Model_Product object
     */		
	protected $_product;	

    /**
     * Search Array for the preg_replace-function of the Magebid Templating System
     * @var array
     */		
	protected $_search_array = array();	
	
    /**
     * Replace Array for the preg_replace-function of the Magebid Templating System
     * @var array
     */			
	protected $_replace_array = array();	
		
    /**
     * Construct
     *
     * @return void
     */			
	protected function _construct()
    {
        $this->_init('magebid/template_renderer');
    }	
	
    /**
     * Generates the eBay Auction Description
     * 
     * This functions renders head,main and footer templates and merges them to the auction description
     * 
     * @param int $header_templates_id DB magebid_templates_id
     * @param int $main_templates_id DB magebid_templates_id
     * @param int $footer_templates_id DB magebid_templates_id
     * 
     * @return string
     */		    
	public function generateDescription($header_templates_id,$main_templates_id,$footer_templates_id)
	{
		//Render Main Template
		$main_template = Mage::getModel('magebid/templates')->load($main_templates_id)->getContent();	
		$main_template = $this->_renderTemplates($main_template);
		
		//Render Header Template
		$header_template = Mage::getModel('magebid/templates')->load($header_templates_id)->getContent();	
		$header_template = $this->_renderTemplates($header_template);		
		
		//Render Footer Template
		$footer_template = Mage::getModel('magebid/templates')->load($footer_templates_id)->getContent();	
		$footer_template = $this->_renderTemplates($footer_template);			
		
		//Build desription
		$description = '<div id="magebid_container"><div id="magebid_inner_container">'.$header_template.$main_template.$footer_template.'</div></div>';
		
		return $description;		
	}
	
    /**
     * Rendering templates
     * 
     * This functions renders the template and search/replace the placehlders with the values
     * 
     * @param string $template Template with placeholders
     * 
     * @return string
     */			
	protected function _renderTemplates($template)
	{
		//For every product attribut
		$attributes = $this->_product->getAttributes();
		foreach ($attributes as $attribute)
		{			
			$value = $attribute->getFrontend()->getValue($this->_product);
			$attribute_code = $attribute->getAttributeCode();

			if (!is_array($value) && !is_object($value))
			{	
				$search = "{{var product_".$attribute_code."}}";
				$this->_search_array[] = $search;
				$this->_replace_array[] = $value;					
			}	
		}
		
		//Create Image Tags
		$this->_createImageTags();	
		
		//Create General Store Tags
		$this->_createStoreTags();
		
		//Replace
		$template = str_replace($this->_search_array,$this->_replace_array,$template);		
		
		//Remove unreplaced tags
		$template = preg_replace('/{{var product_.+?}}/','',$template);		
		
		return $template;					
	}
	
    /**
     * Search/Replace of product image placeholders
     * 
     * This functions creates the entries of the search/replace-array of the image placeholders 
     * and the Image Paths of the Magento Products
     * 
     * @return void
     */		
	protected function _createImageTags()
	{
		//For every product attribut
		$media_gallery = $this->_product->getMediaGallery();
		
		$i = 1;
		if (count($media_gallery['images'])>0)
		{
			foreach ($media_gallery['images'] as $key => $value)
			{
				if ($value['disabled']==0)
				{
					//Replace product_image
					$this->_search_array[] = "{{var product_image".$i."}}";
					$image_path = Mage::getSingleton('catalog/product_media_config')->getBaseMediaUrl().$value['file'];
					$this->_replace_array[] = '<img src="'.$image_path.'" alt="image'.$i.'" class="image'.$i.'" />';
					
					//Replace Link Product Image
					$this->_search_array[] = "{{var link_product_image".$i."}}";
					$this->_replace_array[] = $image_path;
										
					$i++;				
				}
			}			
		}	
	}	
	
    /**
     * Search/Replace of placeholders and store-paths
     * 
     * This functions creates the entries of the search/replace-array of often used store paths
     * 
     * @return void
     */		
	protected function _createStoreTags()
	{
		//Product Media URL
		$this->_search_array[] = "{{product_media_url}}";
		$this->_replace_array[] = Mage::getSingleton('catalog/product_media_config')->getBaseMediaUrl();
		
		//Media URL
		$this->_search_array[] = "{{media_url}}";
		$this->_replace_array[] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);		
		
		//Store URL
		$this->_search_array[] = "{{store_url}}";
		$this->_replace_array[] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);	

		//Link URL
		$this->_search_array[] = "{{link_url}}";
		$this->_replace_array[] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK);	
		
		//Skin URL
		$this->_search_array[] = "{{skin_url}}";
		$this->_replace_array[] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN);	
		
					
	}
	
    /**
     * Assign Product Instance for the current product
     *
     * @return void
     */		 	
	public function setProduct($_product)
	{
		$this->_product = $_product;
	}	
}
?>
