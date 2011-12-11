<?php defined('SYSPATH') or die('No direct script access.');

class Form_Purchase_Delivery_And_Payment extends Forms
{
  public function build()
  {
    
    $delivery_methods = ORM::factory('order_delivery_method')->where('cms_status', '=', 1)->find_all();
    $payment_methods = ORM::factory('order_payment_method')->where('cms_status', '=', 1)->find_all();
    
    // listy
    $list_delivery_methods = $delivery_methods->as_array('id', 'name');
    $list_payment_methods = $payment_methods->as_array('id', 'name');
    
    // defaultni hodnoty
    $default_delivery_method_id = key($list_delivery_methods);
    $default_payment_method_id = key($list_payment_methods);
    
    // hodnoty ze session
    $purchase = Session::instance()->get('purchase');
    
    if (isset($purchase['order_delivery_method_id']) && array_key_exists($purchase['order_delivery_method_id'], $list_delivery_methods)) {
      $default_delivery_method_id = $purchase['order_delivery_method_id'];
    }
    
    if (isset($purchase['order_payment_method_id']) && array_key_exists($purchase['order_payment_method_id'], $list_payment_methods)) {
      $default_payment_method_id = $purchase['order_payment_method_id'];
    }
    
    $this->add('order_delivery_method_id', 'select', array ('options' => $list_delivery_methods, 'value' => $default_delivery_method_id));
    $this->add('order_payment_method_id', 'select', array ('options' => $list_payment_methods, 'value' => $default_payment_method_id));
    
    $delivery_and_payment_methods = array ();
    foreach ($delivery_methods as $delivery_method) {
      $delivery_and_payment_methods[$delivery_method->id] = array ();
      foreach ($delivery_method->order_payment_methods->find_all() as $payment_method) {
        if ($payment_method->cms_status == 1) {
          $delivery_and_payment_methods[$delivery_method->id][ ] = $payment_method->id;
        }
      }
    }
    
    $this->_data['delivery_methods'] = $delivery_methods;
    $this->_data['payment_methods'] = $payment_methods;
    $this->_data['delivery_and_payment_methods'] = $delivery_and_payment_methods;
    $this->_data['free_delivery'] = Eshop::has_free_delivery() === TRUE;
  }
  
  public function set_rules()
  {
    $this->rules('order_delivery_method_id', array (
      array ('not_empty'),
      array (array ($this, 'exists'), array (':value', 'id', 'order_delivery_method')),
    ));
    
    $this->rules('order_payment_method_id', array (
      array ('not_empty'),
      array (array ($this, 'exists'), array (':value', 'id', 'order_payment_method')),
      array (array ($this, 'has_delivery_method'), array (':value')),
    ));
  }
  
  public function do_form($values = array (), $refresh = FALSE, $redirect = TRUE)
  {
    $purchase = Session::instance()->get('purchase', array ());
    
    $purchase['order_delivery_method_id'] = $values['order_delivery_method_id'];
    $purchase['order_payment_method_id'] = $values['order_payment_method_id'];
    
    Session::instance()->set('purchase', $purchase);
    
    Request::redirect_initial(Route::get('purchase-personal_data')->uri());
  }
  
  /**
  * zkontroluje, jestli byl zvolen spravny zpusob platby vuci zpusobu dopravy
  */
  
  public function has_delivery_method($value)
  {
    $payment_method = ORM::factory('order_payment_method', $value);
      
    return $payment_method->has('order_delivery_methods', $this->_formo->order_delivery_method_id->val());
  }
}
