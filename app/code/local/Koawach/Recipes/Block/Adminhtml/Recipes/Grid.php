<?php
class Koawach_Recipes_Block_Adminhtml_Recipes_Grid extends Mage_Adminhtml_Block_Widget_Grid {

  public function __construct() {
    parent::__construct();
    $this->setId('RecipesGrid');
    $this->_parentTemplate = $this->getTemplate();
    $this->setVarNameFilter('koawach_recipes');
    $this->setEmptyText('Keine Rezepte gepflegt');
    $this->setDefaultSort('recipe_id', 'desc');
    $this->setSaveParametersInSession(true);
  }
  protected function _prepareCollection() {
      $collection = Mage::getModel('recipes/recipe')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
    protected function _prepareColumns() {
        $this->addColumn('recipe_id', array(
            'header'=> 'Id',
            'index' => 'recipe_id',
        ));
        $this->addColumn('name', array(
            'header'=> 'Name',
            'index' => 'name',
            'type'	=> 'text'
        ));
        return parent::_prepareColumns();
    }

    public function getGridUrl() {
        return '';
    }
    public function getGridParentHtml()
    {
        $templateName = Mage::getDesign()->getTemplateFilename($this->_parentTemplate, array('_relative'=>true));
        return $this->fetchView($templateName);
    }
    public function getRowUrl($row) {
    	return $this->getUrl('recipes/adminhtml_recipes/edit', array())."id/".$row->getRecipeId();
    }
    public function getNewUrl() {
		    return $this->getUrl('recipes/adminhtml_recipes/new', array());
    }
}
