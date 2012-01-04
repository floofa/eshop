<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Order extends ORM_Classic 
{
  protected $_sorting = array ('timestamp' => 'DESC');
  
  protected $_has_many = array ('order_items' => array ());
  
  protected $_filter_as_like = array ('surname');
  
  protected $_prev_state = FALSE;
  
  public function __get($column)
  {
    switch ($column) {
      case 'total_price' :
        return $this->get_total_price();
      case 'total_price_rounded':
        return $this->get_total_price(TRUE);
      case 'total_price_without_vat':
        return $this->get_total_price_without_vat();
      case 'total_price_without_vat_rounded':
        return $this->get_total_price_without_vat(TRUE);
      case 'vat' :
        return $this->get_vat();
      case 'rounding' :
        return $this->get_rounding();
      
      case 'items_price' :
        return $this->get_items_price();
      case 'items_price_without_vat' :
        return $this->get_items_price_without_vat();
        
      case 'delivery_method_price_without_vat':
        return $this->get_delivery_method_price_without_vat();
      case 'payment_method_price_without_vat':
        return $this->get_payment_method_price_without_vat();
      case 'prev_state':
        return $this->_prev_state;
    }
    
    return parent::__get($column);
  }
  
  public function set($column, $value)
  {
    switch ($column) {
      case 'state':
        $this->_prev_state = $this->state;
        break;
    }
  
    return parent::set($column, $value);
  }
  
  public function filters()
  {
    $filters = parent::filters();
    
    $filters['state'] = array (
      array (array ($this, 'change_state'), array (':value')),
    );
    
    return $filters;
  }
  
  public function change_state($value)
  {
    if (Kohana::$config->load('cms.eshop.auto_manipulation_with_stock')) {
      if ($value != $this->state) {
        // zruseni objednavky - odebrat kusy
        if ($value == 4 && $this->state != 4) {
          
        }
      }
    }
    
    return $value;
  }
  
  public function rules()
  {
    return array(
      
    );
  }
  
  public function save(Validation $validation = NULL)
  {
    $this->_db->begin();
    
    try {
      parent::save($validation);
      
      if (Kohana::$config->load('cms.eshop.auto_manipulation_with_stock')) {
        if ($this->_prev_state !== FALSE && $this->_prev_state != $this->state) {
          // zruseni objednavky - odebrat kusy
          if ($this->state == 4 && $this->_prev_state != 4) {
            $this->add_items_to_stock();
          }
          // obnoveni objednavky
          elseif ($this->state != 4 && $this->_prev_state == 4) {
            $this->remove_items_from_stock();
          }
        }
      }
      
      $this->_db->commit();
    }
    catch (Exception $e) {
      $this->_db->rollback();
      throw $e;
    }
    
    return $this;
  }
  
  /**
  * prida vsechny polozky v objednavce na sklad
  * 
  */
  public function add_items_to_stock()
  {
    foreach ($this->order_items->find_all() as $item) {
      $item->add_to_stock();
    }
    
    return $this;
  }
  
  /**
  * odebere vsechny polozky v objednavce ze skladu
  */
  public function remove_items_from_stock()
  {
    foreach ($this->order_items->find_all() as $item) {
      $item->remove_from_stock();
    }
    
    return $this;
  }
  
  public function set_list_item_default(&$arr, $item) 
  {
    $arr['date'] = date('d.m.Y H:i', $item->timestamp);
    $arr['full_name'] = $item->name . ' ' . $item->surname;
    $arr['total_price'] = number_format($item->total_price_rounded, 0, '.', ' ') . ',- Kč';
    $arr['payment_state'] = ___('orders_payment_states.' . $item->payment_state);
    $arr['state'] = ___('orders_states.' . $item->state);
  }
  
  public function get_total_price($round = FALSE)
  {
    $price = $this->items_price + $this->delivery_method_price + $this->payment_method_price;
    return ( ! $round) ? $price : round($price);
  }
  
  public function get_total_price_without_vat($round = FALSE)
  {
    $price = $this->items_price_without_vat + $this->delivery_method_price_without_vat + $this->payment_method_price_without_vat;
    return ( ! $round) ? $price : round($price);
  }
  
  public function get_items_price()
  {
    $res = 0;
    
    foreach ($this->order_items->find_all() as $item) {
      $res += $item->total_price;
    }
    
    return $res;
  }
  
  public function get_items_price_without_vat()
  {
    $res = 0;
    
    foreach ($this->order_items->find_all() as $item) {
      $res += $item->total_price_without_vat;
    }
    
    return $res;
  }
  
  public function get_delivery_method_price_without_vat()
  {
    return round($this->delivery_method_price / (100 + Kohana::config('cms.eshop.delivery_method_vat')) * 100, 2);
  }
  
  public function get_payment_method_price_without_vat()
  {
    return round($this->payment_method_price / (100 + Kohana::config('cms.eshop.payment_method_vat')) * 100, 2);
  }
  
  public function get_vat()
  {
    $price = $this->get_total_price_without_vat();
    
    return round(($price * 1.2), 2) - $this->get_total_price_without_vat();
  }
  
  public function get_rounding()
  {
    $price_without_vat = $this->get_total_price_without_vat();
    $price_with_vat = $this->get_total_price();
    $vat = $this->get_vat();
    
    return $price_with_vat - ($price_without_vat + $vat);
  }
  
  public function delete()
  {
    $this->_db->begin();
    
    try {
      // pokud je zapnuto automaticke pocitani kusu skladem a objednavka nebyla  oznacena jako zrusena, vratime pordukty zpet na sklad
      if (Kohana::config('cms.eshop.auto_manipulation_with_stock') && $this->state != 4) {
        $this->add_items_to_stock();
      }
      
      $return = parent::delete();
      
      $this->_db->commit();
    }
    catch (Exception $e) {
      $this->_db->rollback();
      throw $e;
    }
    
    return $return;
  }
  
  public function get_navigation_val()
  {
    return 'Objednávka č. ' . $this->number;
  }
}
