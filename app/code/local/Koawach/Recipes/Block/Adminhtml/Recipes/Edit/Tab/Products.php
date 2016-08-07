<?php
class Koawach_Recipes_Block_Adminhtml_Recipes_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct(){
        parent::__construct();
        $this->setId('productsGrid');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('in_products'=>1));
    }
    public function getCategory(){
        return Mage::getModel('catalog/category')->load(Mage::app()->getStore()->getRootCategoryId());
    }

    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            }
            elseif(!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
            }
        }
        else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareCollection()
    {
        if ($this->getCategory()->getId()) {
            $this->setDefaultFilter(array('in_products'=>1));
        }
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku');
        $collection->joinAttribute(
                'status',
                'catalog_product/status',
                'entity_id',
                null,
                'inner'
            );
        $collection->joinAttribute(
            'visibility',
            'catalog_product/visibility',
            'entity_id',
            null,
            'inner'
        );
        $this->setCollection($collection);
        if ($this->getCategory()->getProductsReadonly()) {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
        }
        return parent::_prepareCollection();
    }

    protected function _prepareColumns(){
        if (!$this->getCategory()->getProductsReadonly()) {
            $this->addColumn('in_products', array(
                'header_css_class' => 'a-center',
                'type'      => 'checkbox',
                'name'      => 'in_products',
                'values'    => $this->_getSelectedProducts(),
                'field_name'=> 'products[]',
                'align'     => 'center',
                'index'     => 'entity_id'
            ));
        }
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'entity_id'
        ));

        $this->addColumn('sku', array(
          'header' => Mage::helper('catalog')->__('SKU'),
          'width' => '80px',
          'index' => 'sku'
        ));

        $this->addColumn('product_name', array(
            'header' => Mage::helper('catalog')->__('Name'),
            'index' => 'name'
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
                ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
                ->load()
                ->toOptionHash();

        $this->addColumn('visibility', array(
            'header' => Mage::helper('catalog')->__('Visibility'),
            'width' => '90px',
            'index' => 'visibility',
            'type' => 'options',
            'options' => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));


        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/productgrid', array('_current'=>true));
    }

    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()->getPost('store_products');
        if (is_null($products)) {
            $recipe = Mage::getModel('recipes/recipe')->load($this->getRequest()->getParam('id'));
            return explode(',', $recipe->getProductIds());
        }
        return $products;
    }
    public function getSelectedProducts(){
        $products = array();
        $recipe = Mage::getModel('recipes/recipe')->load($this->getRequest()->getParam('id'));
        $productIds = explode(',', $recipe->getProductIds());
        foreach ($productIds as $productId){
            $products[$productId] = array('position'=> 0);
        }
        return $products;
    }
}
