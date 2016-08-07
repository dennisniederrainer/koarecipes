<?php
class Koawach_Recipes_Adminhtml_RecipeController extends Mage_Adminhtml_Controller_Action {

  public function indexAction() {
    // mage::log('hola',null,'RECIPEcontroller.log');
    $this->loadLayout();
    $this->renderLayout();
    return $this;

    $this->loadLayout()->_addContent(
        $this->getLayout()->createBlock('recipes/adminhtml_recipes_grid')
      )->renderLayout();

    //--
    $this->loadLayout();
    $block = $this->getLayout()
    ->createBlock('core/text', 'example-block')
    ->setText('<h1>This is a text block</h1>');
    $this->_addContent($block);
    $this->renderLayout();
    $this->_setActiveMenu('koawach_recipe/recipe');
    return $this;
  }
}
