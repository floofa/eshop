<?php defined('SYSPATH') or die('No direct script access.');

class Form_Basket_Edit extends Forms
{
  public function build()
  {
    $basket = Basket::instance();
    
    foreach ($items = $basket->get_items() as $key => $item) {
      $this->add('item_' . $key, 'input', $item['count']);
    }
    
    $this->_data['items'] = $items;
    $this->_data['items_price'] = $basket->get_items_price();
  }
  
  public function do_form($values = array (), $refresh = FALSE, $redirect = TRUE)
  {
    $basket = Basket::instance();
    $items = $basket->get_items();
    
    foreach ($items as $key => $item) {
      if (isset($values['item_' . $key])) {
        $count = $values['item_' . $key];
        
        if (is_numeric($count) && $count >= 0)
          $basket->set_item_count($key, $count);
      }
    }
    
    Request::refresh_page();
  }
}
