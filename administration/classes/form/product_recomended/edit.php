<?php defined('SYSPATH') or die('No direct script access.');

class Form_Product_Recomended_Edit extends Forms_List
{
  public function build()
  {
    $this->group('group1')->col('col1');
    
    if ( ! $this->_model_id) {
      $this->add('product_code');
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
      $this->rules('product_code', array (
        array ('not_empty'),
        array (array ($this, 'exists'), array (':value', 'code', 'product')),
      ));
    }
  }
  
  public function prepare_values()
  {
    $values = parent::prepare_values();
    
    // nastavi id produktu
    if ( ! $this->_model_id) {
      $values['product_id'] = ORM::factory('product')->where('code', '=', $values['product_code'])->find()->id;
      unset($values['product_code']);
    }
    else {
      unset($values['product_name']);
    }
    
    return $values;
  }
}
