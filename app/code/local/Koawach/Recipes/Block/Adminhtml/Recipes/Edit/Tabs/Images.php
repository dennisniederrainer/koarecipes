<?php

class Koawach_Recipes_Block_Adminhtml_Recipes_Edit_Tab_Coredata extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        //prepare info form that this want to view

        $form = new Varien_Data_Form();
        $this->setForm($form);

        if (Mage::getSingleton('adminhtml/session')->getStorelocatorData()) {
          $data = Mage::getSingleton('adminhtml/session')->getRecipeData();
          Mage::getSingleton('adminhtml/session')->setRecipeData(null);
        } elseif (Mage::registry('recipe_data')) {
          $data = Mage::registry('recipe_data')->getData();
        }

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();
        $wysiwygConfig->addData(array(
            'add_variables' => false,
            'plugins' => array(),
            'widget_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/widget/index'),
            'directives_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive'),
            'directives_url_quoted' => preg_quote(Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg/directive')),
            'files_browser_window_url' => Mage::getSingleton('adminhtml/url')->getUrl('adminhtml/cms_wysiwyg_images/index'),
        ));

        //General Info
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
            'wysiwyg' => true,
            'style' => 'height:12em;width:36em;',
            'config'    => $wysiwygConfig,
            'required' => true )
          );
          $fieldset->addField('ingredients', 'editor',
            array (
            'name' => 'ingredients',
            'label' => 'Zutaten',
            'wysiwyg' => true,
            'style' => 'height:12em;width:36em;',
            'config'    => $wysiwygConfig,
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

        $form->setValues($data);

        return parent::_prepareForm();
    }

}
