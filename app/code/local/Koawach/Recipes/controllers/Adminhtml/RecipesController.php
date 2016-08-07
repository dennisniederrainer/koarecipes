<?php
class Koawach_Recipes_Adminhtml_RecipesController extends Mage_Adminhtml_Controller_Action {

  protected function _initAction() {
      $this->loadLayout()
              ->_setActiveMenu('recipes/recipes');
      return $this;
  }

  public function indexAction() {
    // mage::log('hola',null,'RECIPEcontroller.log');
    // $this->_initAction()
            // ->renderLayout();

    $this->loadLayout()->_addContent(
        $this->getLayout()->createBlock('recipes/adminhtml_recipes')
      )->renderLayout();
    return $this;
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
          $this->_addContent($this->getLayout()->createBlock('recipes/adminhtml_recipes_edit'));

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

      $productIds = array();
      if (isset($data['sproducts'])) {
          if (is_string($data['sproducts'])) {
              parse_str($data['sproducts'], $productIds);
              $productIds = array_unique(array_keys($productIds));
          }
          $data['product_ids'] = implode(',', $productIds);
      }

      // $urlRewrite = $data['rewrite_request_path'] ? $data['rewrite_request_path'] : $data['name'];
      // $urlRewrite = strtolower(trim($urlRewrite));
      // $urlRewrite = Mage::helper('storelocator')->characterSpecial($urlRewrite);
      //
      // $data['rewrite_request_path'] = $urlRewrite;
      $model->setData($data)
              // ->setStoreId($store)
              ->setData('recipe_id', $id);
      try {
          $model->save();
          $id = $model->getId();

          // $stores = Mage::app()->getStores();
          // foreach ($stores as $store) {
          //     $model->setStoreId($store->getStoreId())
          //             ->updateUrlKey();
          // }

          Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Recipe was successfully saved'));
          Mage::getSingleton('adminhtml/session')->setFormData(false);
          // Mage::helper('storelocator/image')->saveImageStore($data['storelocator_images'], $data['storelocator_values'], $id);
          // if ($id == null) {
          //     if (!isset($data['radio'])) {
          //         $data['radio'] = 1;
          //     }
          //
          //
          //     if (isset($_FILES['image_icon']) && $_FILES['image_icon']['name']) {
          //         Mage::helper('storelocator')->saveIcon($_FILES['image_icon'], $model->getCollection()->getLastItem()->getId());
          //     }
          // } else {
          //
          //     if (isset($_FILES['image_icon']) && $_FILES['image_icon']['name']) {
          //         Mage::helper('storelocator')->saveIcon($_FILES['image_icon'], $id);
          //     }
          // }
          //
          // if (isset($data['tags_store'])) {
          //     $tag = explode(",", $data['tags_store']);
          //     $tags = array();
          //     foreach ($tag as $item) {
          //         $itemTag = trim($item);
          //         if ($itemTag)
          //             $tags[] = $itemTag;
          //     }
          //     Mage::helper('storelocator')->saveTagToStore($tags, $model->getId());
          // }
          //
          // if ($deleteIcon) {
          //     Mage::helper('storelocator')->deleteImageIcon($model->getId(), $data['image_icon']);
          // }

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
}
