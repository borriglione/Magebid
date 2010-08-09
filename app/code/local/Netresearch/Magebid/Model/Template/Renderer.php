<?php
class Netresearch_Magebid_Model_Template_Renderer extends Mage_Core_Model_Abstract
{	
	protected $_product;	
	protected $_search_array = array();	
	protected $_replace_array = array();	
		
		
	protected function _construct()
    {
        $this->_init('magebid/template_renderer');
    }	
	
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
	
	
	public function setProduct($_product)
	{
		$this->_product = $_product;
	}	
}
?>
