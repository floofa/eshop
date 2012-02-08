<?php defined('SYSPATH') or die('No direct script access.');

class Form_Product_Recommended_Edit extends Forms_List
{
  public function build()
  {
    $this->group('group1')->col('col1');
    
    if ( ! $this->_model_id) {
      $this->add('product_id', 'selectchosen', array ('options' => array ('' => '--- Vyberte ---') + ORM::factory('product')->find_all()->as_array('id', 'name')));
    }
    else {
      $product_news = $this->_load_orm_object();
      $product = $product_news->product;
      $this->add('product_name', array ('value' => $product->code . ' - ' . $product->name, 'editable' => FALSE));
    }
    
    $this->col('col2')
      ->add('cms_status', 'bool', TRUE);
  }
  
  public function set_rules()
  {
    if ( ! $this->_model_id) {
      $this->rules('product_id', array (
        array ('not_empty'),
        array (array ($this, 'exists'), array (':value', 'id', 'product')),
      ));
    }
  }
  
  public function prepare_values()
  {
    $values = parent::prepare_values();
    
    unset($values['product_name']);
        
    return $values;
  }
}
