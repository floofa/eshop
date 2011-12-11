<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Order extends ORM 
{
  protected $_sorting = array ('timestamp' => 'DESC');
  
  protected $_belongs_to = array ('vat_rate' => array ());
  
  protected $_has_many = array ('order_items' => array ());
  
  public function __get($column)
  {
    switch ($column) {
      case 'total_price' :
        return $this->get_total_price();
      case 'total_price_rounded':
        return $this->get_total_price(TRUE);
      case 'total_price_without_vat':
        return $this->get_total_price_without_vat();
      
      case 'items_price' :
        return $this->get_items_price();
    }
    
    return parent::__get($column);
  }
  
  public function save(Validation $validation = NULL)
  {
    $is_new = ! (bool) $this->id;
    
    if ( ! strlen($this->hash)) {
      $this->hash = text::random('alpha', 20);
    }
    
    parent::save($validation);
    
    if ($is_new) {
      // nastaveni cisla objednavky a var. symbolu
      $this->set_number()->set_vs();
      
      parent::save();
    }
    
    return $this;
  }
  
  public function set_delivery_method($delivery_method_id, $free_delivery = FALSE)
  {
    $delivery_method = ORM::factory('order_delivery_method', $delivery_method_id);
    
    $this->delivery_method_name = $delivery_method->name;
    $this->delivery_method_sys_name = $delivery_method->sys_name;
    $this->delivery_method_price_with_vat = ($free_delivery) ? 0 : $delivery_method->price_with_vat;
    $this->delivery_method_price_without_vat = ($free_delivery) ? 0 : $delivery_method->price_without_vat;
    $this->delivery_method_vat_rate = $delivery_method->vat_rate->value;
    
    return $this;
  }
  
  public function set_payment_method($payment_method_id, $free_delivery = FALSE)
  {
    $payment_method = ORM::factory('order_payment_method', $payment_method_id);

    $this->payment_method_name = $payment_method->name;
    $this->payment_method_sys_name = $payment_method->sys_name;
    $this->payment_method_type = $payment_method->payment_type;
    $this->payment_method_price_with_vat = ($free_delivery) ? 0 : $payment_method->price_with_vat;
    $this->payment_method_price_without_vat = ($free_delivery) ? 0 : $payment_method->price_without_vat;
    $this->payment_method_vat_rate = $payment_method->vat_rate->value;
    
    return $this;
  }
  
  /**
  * vrati konecnou cenu s DPH
  */
  public function get_total_price($round = FALSE)
  {
    $price = $this->get_items_price() + $this->delivery_method_price + $this->payment_method_price;
    
    return ( ! $round) ? $price : round($price);
  }
  
  /**
  * vrati konecnou cenu bez DPH
  */
  public function get_total_price_without_vat($round = FALSE)
  {
    $price = $this->get_items_price_without_vat() + $this->get_delivery_method_price_without_vat() + $this->get_payment_method_price_without_vat();
    return ( ! $round) ? $price : round($price);
  }
  
  /**
  * vrati cenu s DPH vsech produktu v objednavce
  */
  public function get_items_price()
  {
    $res = 0;
    
    foreach ($this->order_items->find_all() as $item) {
      $res += $item->total_price;
    }
    
    return $res;
  }
  
  /**
  * vrati cenu bez DPH vsech produktu v objednavce
  */
  public function get_items_price_without_vat()
  {
    $res = 0;
    
    foreach ($this->order_items->find_all() as $item) {
      $res += $item->total_price_without_vat;
    }
    
    return $res;
  }
  
  /**
  * vrati celkovou sazbu DPH
  */
  public function get_total_vat()
  {
    return $this->get_items_vat() + $this->get_delivery_method_vat() + $this->get_payment_method_vat();
  }
  
  /**
  * vrati DPH pro polozky
  */
  public function get_items_vat()
  {
    $res = 0;
    
    foreach ($this->order_items->find_all() as $item) {
      $res += $item->get_total_vat();
    }
    
    return $res;
  }
  
  /**
  * vrati cenu dopravy bez DPH
  */
  public function get_delivery_method_price_without_vat()
  {
    return round($this->delivery_method_price / (100 + $this->delivery_method_vat) * 100, 2);
  }
  
  /**
  * vrati DPH pro zpusob dopravy
  */
  public function get_delivery_method_vat()
  {
    $price_without_vat = $this->get_delivery_method_price_without_vat();
    
    return $price_without_vat / 100 * (100 + $this->delivery_method_vat) - $price_without_vat;
  }
  
  /**
  * vrati cenu platby bez DPH
  */
  public function get_payment_method_price_without_vat()
  {
    return round($this->payment_method_price / (100 + $this->payment_method_vat) * 100, 2);
  }
  
  /**
  * vrati DPH pro zpusob platby
  */
  public function get_payment_method_vat()
  {
    $price_without_vat = $this->get_payment_method_price_without_vat();
    
    return $price_without_vat / 100 * (100 + $this->payment_method_vat) - $price_without_vat;
  }
  
  public function get_rounding()
  {
    return $this->get_total_price() - ($this->get_total_price_without_vat() + $this->get_total_vat());
  }

  
  public function set_number($save = FALSE)
  {
    $this->number = $this->id;
    
    if ($save)
      $this->save();
      
    return $this;
  }
  
  public function set_vs($save = FALSE)
  {
    $this->vs = $this->id;
    
    if ($save)
      $this->save();
      
    return $this;
  }
}