<?php defined('SYSPATH') or die('No direct script access.');

class Form_Basket_Add extends Forms
{
  public function __construct($name, $folder = FALSE, $model = FALSE, $model_id = FALSE, $data = array ())
  {
    $this->_name = $name;
    $this->_folder = $folder;
    $this->_model = $model;
    $this->_model_id = $model_id;
    $this->_data = $data;
    
    $this->_formo = Formo::form('form_' . (($this->_folder !== FALSE) ? $this->_folder . '_' : '') . $this->_name . '_' . $this->_data['product']->id);
    $this->_formo->view()->attr('id', $this->_formo->alias());
    
    if ($this->_formo_view_prefix !== FALSE)
      $this->_formo->set('view_prefix', $this->_formo_view_prefix);
  }
  
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
