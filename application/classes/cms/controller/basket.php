<?php defined('SYSPATH') or die('No direct script access.');

abstract class Cms_Controller_Basket extends Controller_Builder_Template_Application
{
  /**
  * kosik - vypis
  */
  public function action_index()
  {
    $this->_view->count_items = Basket::instance()->get_count_species();
    $this->_view->free_delivery = Eshop::has_free_delivery();
  }
  
  /**
  * pridani polozky do kosiku
  */
  public function action_add_item()
  {
    $count = $this->request->param('count', 1);
    
    if ( ! valid::digit($count) || $count <= 0) {
      $count = 1;
    }
    
    $product = ORM::factory('product')->where('rew_id', '=', $this->request->param('rew_id'))->find();
    
    if ($product->allowed_add_to_basket()) {
      $item = $product->as_array();
      $item['price'] = $product->price;
      
      $basket = Basket::instance();
      $basket->add_item($item, $count);
    }
    
    Request::redirect_initial(Route::get('basket')->uri());
  }
  
  /**
  * odebrani zbozi z kosiku
  */
  public function action_remove_item()
  {
    $key = $this->request->param('key');
    
    Basket::instance()->remove_item($key);
    
    Request::redirect_initial(Route::get('basket')->uri());
  }
}