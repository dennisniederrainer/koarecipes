<?php

class Koawach_Recipes_Model_Mysql4_Recipe extends Mage_Core_Model_Mysql4_Abstract {

  public function _construct() {
      $this->_init('recipes/recipe', 'recipe_id');
  }
}
