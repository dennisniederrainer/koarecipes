<?php
class Koawach_Recipes_Block_Adminhtml_Recipes_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

  private $_recipe;

  public function __construct() {
    parent::__construct();

    $this->_objectId = 'id';
    $this->_blockGroup = 'recipes';
    $this->_controller = 'adminhtml_recipes';
	}

	public function getHeaderText() {
    return $this->__('Koawach Recipe');
  }

	public function getRecipe() {
		if ($this->_recipe == null) {
			$this->_recipe = mage::getModel('recipes/recipe')->load($this->getRequest()->getParam('id'));
		}
		return $this->_recipe;
	}
	public function getSaveUrl() {
    return $this->getUrl('recipes/adminhtml/recipe/save');
  }
}
