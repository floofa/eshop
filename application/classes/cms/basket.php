<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Basket 
{
  public static $session_name = 'eshop_basket';
  
  protected static $_instance = NULL;
  
  protected $_items = array ();
  
  public static function instance()
  {
    if (is_null(self::$_instance)) {
      if ($instance = Session::instance()->get(self::$session_name)) {
        self::$_instance = $instance;
      }
      else {
        self::$_instance = new Basket();
      }
    }
      
    return self::$_instance;
  }
  
  public function __construct()
  {
    $this->save();
  }
  
  /**
  * ulozi instanci do session
  */
  public function save()
  {
    Session::instance()->set(self::$session_name, $this);

    return $this;
  }
  
  public function add_item($item, $count = 1)
  {
    if ( ! isset($item['index'])) {
      $item['index'] = $item['id'];
    }

    $this->_items[$item['index']] = array
    (
      'id' => $item['id'],
      'rew_id' => $item['rew_id'],
      'name' => $item['name'],
      'price' => $item['price'],
      'price_without_vat' => $item['price_without_vat'],
      'count' => (isset($this->_items[$item['index']])) ? $this->_items[$item['index']]['count'] + $count : $count,
    );

    return $this->save();
  }
  
  public function set_item_count($key, $count)
  {
    if (isset($this->_items[$key])) {
      $this->_items[$key]['count'] = ($count > 0) ? $count : 0;
      $this->save();
    }

    return $this;
  }
  
  /**
  * odebere z kosiku pozadovany pocet kusu nebo celou polozku
  */
  public function remove_item($key, $count = FALSE)
  {
    if (isset($this->_items[$key])) {
      if ($count === FALSE)
        unset($this->_items[$key]);
      else {
        $this->_items[$key]['count'] = (($this->_items[$key]['count'] - $count) > 0) ? $this->_items[$key]['count'] - $count : 0;
      }

      $this->save();
    }
    
    return $this;
  }
  
  /**
  * vrati vsechny polozky
  */
  public function get_items()
  {
    return $this->_items;
  }
  
  /**
  * pocet druhu zbozi v kosiku
  *
  */
  public function get_count_species()
  {
    return count($this->_items);
  }

  /**
  * vrati pocet kusu v kosiku
  *
  */
  public function get_count_items()
  {
    $count = 0;

    foreach ($this->_items as $item) {
      $count += $item['count'];
    }

    return $count;
  }
  
  /**
  * vrati celkovou cenu produktu v kosiku
  */
  public function get_items_price()
  {
    $price = 0;

    foreach ($this->_items as $item) {
      $price += $item['count'] * $item['price'];
    }

    return $price;
  }
  
  public function clear()
  {
    $this->_items = array ();
    $this->save();
  }
}
