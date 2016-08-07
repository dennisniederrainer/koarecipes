<?php
class Koawach_Recipes_Block_Adminhtml_Recipes_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

  protected function _prepareForm() {
      $form = new Varien_Data_Form(array(
          'id' => 'edit_form',
          'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
          'method' => 'post',
         )
      );
      $fieldset = $form->addFieldset('recipe_data', array('legend'=>'Stammdaten'));
      $fieldset->addField('name', 'text', array(
          'label'     => 'Name',
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
        ));
       $fieldset->addField('type_id', 'select', array(
           'label'     => 'Zubereitungsart',
           'class'     => 'required-entry',
           'required'  => true,
           'name'      => 'type_id',
           'values'    => array(
             array('value' => 0, 'label' => 'Kochen'),
             array('value' => 1, 'label' => 'Backen & Süßes'),
             array('value' => 2, 'label' => 'Getränke'),
           )
        ));
        $fieldset->addField('description', 'editor',
          array (
          'name' => 'description',
          'label' => 'Beschreibung',
          'style' => 'height:12em;width:36em;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'required' => true )
        );
        $fieldset->addField('ingredients', 'editor',
          array (
          'name' => 'ingredients',
          'label' => 'Zutaten',
          'style' => 'height:12em;width:36em;',
          'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
          'required' => true )
        );
        $fieldset->addField('criteria', 'multiselect', array(
            'label'     => 'Kriterien',
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'criteria',
            'values'    => array(
              array('value' => 1, 'label' => 'vegan'),
              array('value' => 2, 'label' => 'vegetarisch'),
              array('value' => 3, 'label' => 'laktosefrei'),
              array('value' => 3, 'label' => 'glutenfrei'),
              array('value' => 3, 'label' => 'kalorienarm'),
            )
         ));
        $fieldset = $form->addFieldset('recipe_additional_data', array('legend'=>'Extras'));
        $fieldset->addField('duration', 'text', array(
            'label'     => 'Dauer',
            'name'      => 'duration',
        ));
        $fieldset->addField('number_of_person', 'text', array(
            'label'     => '#Personen',
            'name'      => 'number_of_person',
        ));
        $fieldset->addField('video_url', 'text', array(
            'label'     => 'Video Url',
            'name'      => 'video_url',
        ));
        $fieldset->addField('author', 'text', array(
            'label'     => 'Author',
            'name'      => 'author',
        ));

      $form->setUseContainer(true);

      $id = $this->getRequest()->getParam('id');
      $model = Mage::getModel('recipes/recipe')->load($id);
      $form->setValues($model->getData());

      $this->setForm($form);
      return parent::_prepareForm();
  }
}
