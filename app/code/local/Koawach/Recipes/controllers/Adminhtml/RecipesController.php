<?php
class Koawach_Recipes_Adminhtml_RecipesController extends Mage_Adminhtml_Controller_Action {

  protected function _initAction() {
      $this->loadLayout()
              ->_setActiveMenu('recipes');
      return $this;
  }

  public function indexAction() {
    $this->_initAction()->renderLayout();
  }

  public function editAction() {
      $id = $this->getRequest()->getParam('id');

      $model = Mage::getModel('recipes/recipe')->load($id);

      if ($model->getId() || $id == 0) {
          $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
          if (!empty($data)) {
            $model->setData($data);
          }

          Mage::register('recipe_data', $model);

          $this->loadLayout();
          $this->_setActiveMenu('recipes/recipes');

          $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
          $this->_addContent($this->getLayout()->createBlock('recipes/adminhtml_recipes_edit'))
            ->_addLeft($this->getLayout()->createBlock('recipes/adminhtml_recipes_edit_tabs'));;

          $this->renderLayout();
      } else {
          Mage::getSingleton('adminhtml/session')->addError($this->__('Item does not exist'));
          $this->_redirect('*/*/');
      }
  }

  public function newAction() {
    $this->_forward('edit');
  }

  public function saveAction() {
    if ($data = $this->getRequest()->getPost()) {
      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('recipes/recipe');

      // var_dump($data);
      // die('..');

      $productIds = array();
      if (isset($data['products'])) {
          if (is_array($data['products'])) {
            $data['product_ids'] = implode(',', $data['products']);
          }
      }

      $model->setData($data)->setData('recipe_id', $id);
      try {
          $model->save();
          $id = $model->getId();

          Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Recipe was successfully saved'));
          Mage::getSingleton('adminhtml/session')->setFormData(false);

          if ($this->getRequest()->getParam('back')) {
              $this->_redirect('*/*/edit', array('id' => $model->getId()));
              return;
          }
          $this->_redirect('*/*/');
          return;
      } catch (Exception $e) {
          Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
          Mage::getSingleton('adminhtml/session')->setFormData($data);
          $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
          return;
      }
    }

    Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find recipe to save'));
    $this->_redirect('*/*/');
  }

  public function productgridAction(){
      $this->loadLayout();
      $this->getLayout()->getBlock('recipes.edit.tab.products')
           ->setStoreProducts($this->getRequest()->getPost('recipes_products', null));
      $this->renderLayout();
  }
}
