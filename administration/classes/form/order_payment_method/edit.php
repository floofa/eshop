<?php defined('SYSPATH') or die('No direct script access.');

class Form_Order_Payment_Method_Edit extends Forms_List
{
  public function build()
  {
    $this->group('group1');
    $this->col('col1')
      ->add('name')
      ->add('sys_name')
      ->add('payment_type', 'select', array ('options' => ___('payment_types')))
      ->add('description')
      ->add('order_delivery_methods', 'select', array ('value' => ORM::factory('order_payment_method', $this->_model_id)->order_delivery_methods->select_list('id', 'name'), 'options' => ORM::factory('order_delivery_method')->find_all()->as_array('id', 'name'), 'attr' => array ('multiple' => 'multiple')))
      ->add('cms_status', 'bool', TRUE);
    
    $this->col('col2')
      ->add('price_with_vat')
      ->add('price_without_vat', array ('editable' => FALSE))
      ->add('vat_rate_id', 'select', array ('options' => ORM::factory('vat_rate')->find_all()->as_array('id', 'name')));
  }
  
  public function set_rules()
  {
    $this->rules('name', array (
      array ('not_empty'),
      array ('max_length', array (':value', 30)),
    ));
    
    $this->rules('description', array (
      array ('max_length', array (':value', 100)),
    ));
    
    $this->rules('price_with_vat', array (
      array ('not_empty'),
      array ('digit', array (':value')),
    ));
    
    $this->rules('sys_name', array (
      array (array ($this, 'is_unique'), array (':value', ':field'))
    ));
  }
  
  public function prepare_values()
  {
    $values = parent::prepare_values();
    arr::arr_without(array ('price_without_vat'), $values);

    return $values;
  }
}
