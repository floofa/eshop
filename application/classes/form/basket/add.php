<?php defined('SYSPATH') or die('No direct script access.');

class Form_Basket_Add extends Forms
{
  public function build()
  {
    $this->add('count', 'input', 1);
  }
  
  public function prepare_values()
  {
    $values = parent::prepare_values();
    $values['count'] = (int) $values['count'];
    
    return $values;
  }
  
  public function do_form($values = array (), $refresh = FALSE, $redirect = TRUE)
  {
    Request::redirect_initial(Route::get('basket-add_item')->uri(array ('rew_id' => $this->_data['product']->rew_id, 'count' => $values['count'])));
  }
}
