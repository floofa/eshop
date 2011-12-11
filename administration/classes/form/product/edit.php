<?php defined('SYSPATH') or die('No direct script access.');

class Form_Product_Edit extends Forms_List
{
  public function build()
  {
    $this->group('group1');
    $this->col('col1')
      ->add('name')
      ->add('rew_id')
      ->add('product_category_id', 'select', array ('options' => array ('' => '--- Vyberte ---') + ORM::factory('product_categorymptt')->select_list_last()));
    
    $this->col('col2')
      ->add('code')
      ->add('count_stock', 'input', 0)
      ->add('cms_status', 'bool', TRUE);
    
    $this->group('group2');
    $this->col('col1')
      ->add((Kohana::$config->load('cms.eshop.calculate_price_without_vat')) ? 'price_with_vat' : 'price_without_vat')
      ->add((Kohana::$config->load('cms.eshop.calculate_price_without_vat')) ? 'price_without_vat' : 'price_with_vat', array ('editable' => FALSE))
      ->add('discount')
      ->add('vat_rate_id', 'select', array ('options' => ORM::factory('vat_rate')->find_all()->as_array('id', 'name')));
      
    $this->col('col2')
      ->add((Kohana::$config->load('cms.eshop.calculate_price_without_vat')) ? 'price_final_with_vat' : 'price_final_without_vat', array ('editable' => FALSE))
      ->add((Kohana::$config->load('cms.eshop.calculate_price_without_vat')) ? 'price_final_without_vat' : 'price_final_with_vat', array ('editable' => FALSE))
      ->add('discount_perc');
      
    $this->group('group3');
    $this->col('col1')
      ->add('meta_keywords');
      
    $this->col('col2')
      ->add('meta_description');
      
    $this->col('col')
      ->add('short_description', 'textarea', array ('attr' => array ('rows' => 5)))
      ->add('description', 'textarea', array ('attr' => array ('rows' => 5)));

    $this->add_gallery('product_images', $this->_model, $this->_model_id);
  }
  
  public function set_rules()
  {
    $this->rules('name', array (
      array ('not_empty'),
      array ('max_length', array (':value', 95)),
    ));
    
    $this->rules('rew_id', array (
      array ('max_length', array (':value', 97)),
    ));
    
    $this->rules('code', array (
      array ('not_empty'),
      array ('max_length', array (':value', 20)),
      array (array ($this, 'is_unique'), array (':value', ':field')),
    ));
    
    $this->rules('product_category_id', array (
      array ('not_empty'),
    ));
    
    $this->rules('count_stock', array (
      array ('not_empty'),
      array ('int', array (':value')),
    ));
    
    if (Kohana::$config->load('cms.eshop.calculate_price_without_vat'))
      $this->rules('price_with_vat', array (
        array ('not_empty'),
        array ('digit', array (':value')),
      ));
    else {
      $this->rules('price_without_vat', array (
        array ('not_empty'),
        array ('numeric', array (':value')),
      ));
    }
    
    $this->rules('discount', array (
      array ('int', array (':value')),
    ));
    
    $this->rules('discount_perc', array (
      array ('range', array (':value', 0, 100)),
    ));
  }
  
  public function prepare_values()
  {
    $values = parent::prepare_values();
    arr::arr_without(array ((Kohana::$config->load('cms.eshop.calculate_price_without_vat')) ? 'price_without_vat' : 'price_with_vat', 'price_final_with_vat', 'price_final_without_vat'), $values);

    return $values;
  }
}
