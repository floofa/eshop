<?php defined('SYSPATH') or die('No direct script access.');

class Form_Order_Item_Edit extends Forms_List
{
  public function build()
  {
    $this->group('group1');
    
    if ( ! $this->_model_id) {
      $this->col('col1')
        ->add('product_id', 'selectchosen', array ('options' => array ('' => '') + ORM::factory('product')->find_all()->as_array('id', 'name')));  
    }
    else {
      $this->col('col1')
      ->add('name', array ('editable' => FALSE))
      ->add('code', array ('editable' => FALSE));
    }
    
    $this->col('col2');
      
    // cena
    if (Kohana::$config->load('cms.eshop.calculate_price_without_vat'))
      $this->add('price_with_vat');
    else
      $this->add('price_without_vat');
      
    $this->add('vat_rate')
         ->add('count');
  }
  
  public function set_rules()
  {
    if ( ! $this->_model_id) {
      $this->rules('product_id', array (
        array ('not_empty'),
        array (array ($this, 'exists'), array (':value', 'id', 'product')),
      ));
    }
    
    $this->rules('vat_rate', array (
      array ('digit'),
      array ('range', array (':value', 0, 100)),
    ));
    
    if (Kohana::$config->load('cms.eshop.calculate_price_without_vat'))
      $this->rules('price_with_vat', array (
        array ('digit', array (':value')),
      ));
    else {
      $this->rules('price_without_vat', array (
        array ('numeric', array (':value')),
      ));
    }
    
    $this->rules('count', array (
      array ('digit'),
    ));
  }
  
  public function do_form($values = array (), $refresh = FALSE, $redirect = TRUE)
  {
    if ( ! $this->_model_id) {
      $product = ORM::factory('product', $values['product_id']);
      
      $values['order_id'] = $this->_data['order_id'];
      $values['code'] = $product->code;
      $values['name'] = $product->name;
    }
    else {
      $product = $this->_load_orm_object()->product;
    }
    
    // nastaveni poctu kusu
    if ( ! strlen($values['count'])) {
      $values['count'] = 1;
    }
    
    // nastaveni ceny
    if ( ! strlen($values[(Kohana::$config->load('cms.eshop.calculate_price_without_vat')) ? 'price_with_vat' : 'price_without_vat'])) {
      $values[(Kohana::$config->load('cms.eshop.calculate_price_without_vat')) ? 'price_with_vat' : 'price_without_vat'] = $product->price_final;
    }
      
    // nastaveni sazby DPH
    if ( ! strlen($values['vat_rate'])) {
      $values['vat_rate'] = $product->vat_rate->value;
    }
    
    parent::do_form($values, $refresh, Route::get('default')->uri(array ('controller' => Request::initial()->controller(), 'action' => 'edit', 'id' => $this->_data['order_id'])));
  }
}
