<?php defined('SYSPATH') or die('No direct script access.');

class Cms_Controller_Orders extends Controller_Builder_Template_Administration_Classic
{                 
  protected $_list_new = FALSE;
  
  public function action_edit()
  {
    $id = $this->request->param('id');
    $item = ORM::factory($this->_model, $id);
    
    // pokud bylo zadano id neexistujiciho zaznamu, presmeruje se na vytvoreni
    if ($id && ! $item->loaded())
      Request::redirect_initial($this->request->route()->uri(array ('controller' => $this->request->controller(), 'action' => $this->request->action(), 'id' => '0')));
    
    if ( ! $item->loaded()) {
      $s = 'navigation_' . $this->request->controller() . '_new';
      Navigation::add((___($s) != $s) ?  ___($s) : ___('navigation_new'), Request::initial_url());
    }
    else {
      Navigation::add($item->get_navigation_val(), Request::initial_url());
      $s = 'navigation_' . $this->request->controller() . '_edit';
      Navigation::add((___($s) != $s) ?  ___($s) : ___('navigation_edit'), Request::initial_url());
      
      $this->_add_bookmarks($id);
    }
    
    $args = func_get_args();
    
    // form
    $form_data = $this->set_form_data($args);
    
    $this->_view->order = $item;
    $this->_view->order_items = $item->order_items->find_all();
    $this->_view->form = Forms_List::get($this->_form_name, $this->_model, $this->_model, $id, $form_data);
  }
  
  public function action_edit_item()
  {
    $id = $this->request->param('id');
    $item_id = $this->request->param('item_id');
    
    $order = ORM::factory('order', $id);
    
    if ( ! $order->loaded())
      Request::redirect_initial($this->request->route()->uri(array ('controller' => $this->request->controller(), 'action' => 'list')));
      
    $item = ORM::factory('order_item', $item_id);
    
    Navigation::add('Objednávka č. ' . $order->id, Route::url('default', array ('controller' => $this->request->controller(), 'action' => 'edit', 'id' => $id)));
    
    if ( ! $item->loaded())
      Navigation::add('Nová položka', Request::initial_url());
    else {
      Navigation::add('Editace položky', Request::initial_url());
    }
    
    $this->_add_bookmarks($id);

    $this->_view = View::factory('pages/builder/edit');
    $this->_view->form = Forms_List::get('edit', 'order_item', 'order_item', $item_id, array ('order_id' => $id));
    $this->_view->form->link_back = Route::url('default', array ('controller' => $this->request->controller(), 'action' => 'edit', 'id' => $id));
  }
  
  public function action_delete_item()
  {
    $item = ORM::factory('order_item', $this->request->param('item_id', '0'));

    if ($item->loaded())
      $item->delete();
    
    Request::redirect_initial(Route::get('default')->uri(array ('controller' => $this->request->controller(), 'action' => 'edit', 'id' => $this->request->param('id'))));
  }
}

