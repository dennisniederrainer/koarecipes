<?php

class Koawach_Recipes_Block_Adminhtml_Recipes extends Mage_Adminhtml_Block_Widget_Grid_Container {

	public function __construct() {
		$this->_controller = 'adminhtml_recipes';
		$this->_blockGroup = 'recipes';
		$this->_headerText = $this->__('Koawach Rezepte');
    $this->_addButtonLabel = $this->__('Add Recipe');
    parent::__construct();
	}
}
