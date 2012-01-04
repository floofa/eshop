<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Order_Item extends ORM_Classic 
{
  protected $_belongs_to = array ('order' => array (), 'product' => array ());
  protected $_prev_count = NULL;
  
  public function __get($column)
  {
    switch ($column) {
      case 'total_price' :
        return $this->get_total_price();
      case 'total_price_without_vat' :
        return $this->get_total_price(FALSE);
      case 'vat' :
        return $this->get_vat();
    }
    
    return parent::__get($column);
  }
  
  public function set($column, $value)
  {
    switch ($column) {
      case 'count':
        $this->_prev_count = $this->count;
        break;
    }
  
    return parent::set($column, $value);
  }
  
  public function save(Validation $validation = NULL)
  {
    $this->_db->begin();
    
    try {
      // nastavi cenu s DPH / bez DPH - v zavislosti na konfiguraci
      if (Kohana::$config->load('cms.eshop.calculate_price_without_vat'))
        $this->set_price_without_vat();
      else
        $this->set_price_with_vat();
      
      parent::save($validation);
      
      // zapnuto automaticke pocitani kusu skladem a objednavka neni zrusena
      if (Kohana::$config->load('cms.eshop.auto_manipulation_with_stock') && $this->order->state != 4) {
        if ($this->_prev_count != $this->count) {
          // pridani zbozi do objednavky
          if ($this->count > $this->_prev_count) {
            $this->remove_from_stock($this->count - $this->_prev_count);
          }
          // odebrani zbozi z objednavky
          elseif ($this->count < $this->_prev_count) {
            $this->add_to_stock($this->_prev_count - $this->count);
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
  * nastavi cenu s DPH
  */
  public function set_price_with_vat()
  {
    $this->price_with_vat = ORM::factory('vat_rate')->calculate_price_with_vat($this->price_without_vat, $this->vat_rate);
    
    return $this;
  }
  
  /**
  * nastavi cenu bez DPH
  */
  public function set_price_without_vat()
  {
    $this->price_without_vat = ORM::factory('vat_rate')->calculate_price_without_vat($this->price_with_vat, $this->vat_rate);
    
    return $this;
  }
  
  public function delete()
  {
    $this->_db->begin();
    
    try {
      // zapnuto automaticke pocitani kusu skladem a objednavka neni zrusena
      if (Kohana::$config->load('cms.eshop.auto_manipulation_with_stock') && $this->order->state != 4) {
        $this->add_to_stock();
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
  
  public function get_total_price($vat = TRUE)
  {
    $column = ($vat) ? 'price_with_vat' : 'price_without_vat';
    
    return $this->{$column} * $this->count;
  }
  
  public function set_list_item_default(&$arr, $item) 
  {
    $arr['price'] = number_format($item->price, 0, '.', ' ') . ',- Kč';
    $arr['count'] = $item->count . 'x';
    $arr['total_price'] = number_format($item->total_price, 0, '.', ' ') . ',- Kč';
  }
  
  public function get_vat($round = TRUE)
  {
    $vat = $this->price_with_vat - $this->price_without_vat;
    
    if ($round)
      return round($vat);
  }
  
  /**
  * prida polozku na sklad
  * 
  */
  public function add_to_stock($count = FALSE)
  {
    $product = ORM::factory('product', $this->product_id);
    
    if ($product->loaded()) {
      $product->count_stock += ($count !== FALSE) ? $count : $this->count;
      $product->save();
    }
    
    return $this;
  }
  
  /**
  * odebere polozku ze skladu
  */
  public function remove_from_stock($count = FALSE)
  {
    $product = ORM::factory('product', $this->product_id);
    
    if ($product->loaded()) {
      $product->count_stock -= ($count !== FALSE) ? $count : $this->count;
      $product->save();
    }
    
    return $this;
  }
}