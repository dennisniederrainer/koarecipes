<?php

class Koawach_Recipes_Block_Adminhtml_Recipes_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

  public function __construct(){
		parent::__construct();
		$this->setId('recipe_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($this->__('Recipe'));
	}

	protected function _beforeToHtml(){
    $coredataTab = new Varien_Object();
    $coredataTab->setContent(
      $this->getLayout()->createBlock('recipes/adminhtml_recipes_edit_tab_coredata')->toHtml());

    // Mage::dispatchEvent('storelocator_general_information_tab_before',
    //         array('tab' => $generalTab,
    //             'store_id' => $this->getRequest()->getParam('id')));

    $this->addTab('form_section', array(
            'label'	    => $this->__('Core Data'),
            'title'	    => $this->__('Core Data'),
            'content'	  => $coredataTab->getContent(),
    ));

    $this->addTab('products', array(
        'label'     => $this->__('Products'),
        'title'     => $this->__('Products'),
       'content'    => $this->getLayout()->createBlock('recipes/adminhtml_recipes_edit_tab_products')->toHtml(),

    ));
    //
    // $this->addTab('images', array(
    //    'label'    => $this->__('Images'),
    //    'title'    => $this->__('Images'),
    //    'content'  => $this->getLayout()->createBlock('recipes/adminhtml_recipes_edit_tab_images')->toHtml(),
    // ));

    return parent::_beforeToHtml();
	}
}
