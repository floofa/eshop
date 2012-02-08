<?php defined('SYSPATH') or die('No direct script access.');

abstract class Cms_Controller_Static_Eshop extends Controller_Builder_Static
{ 
  protected $_folder = 'eshop';
  
  /**
  * kategorie produktu
  */
  public function action_categories_menu() 
  {
    $menu = new Menu('product_categories');
    
    foreach (ORM::factory('product_category')->get_top_items() as $category_lvl1) {
      $menu_item_lvl1 = $menu->add($category_lvl1->name, $category_lvl1->get_url());
      
      foreach ($category_lvl1->get_children() as $category_lvl2) {
        if ( ! $category_lvl2->cms_status)
          continue;
        
        $menu->add_sub($menu_item_lvl1, $category_lvl2->name, $category_lvl2->get_url());
      }
    }
    
    $menu->set_actives(Request::initial()->url(TRUE));
    
    $this->_view->menu = $menu;
  }
  
  public function action_list_product()
  {
    $product = ORM::factory('product', $this->request->param('id'));
    
    if ( ! $product->loaded())
      return;
      
    $this->_view->product = $product;
    $this->_view->last = $this->request->query('last');
  }
  
  public function action_basket_small()
  {
    $basket = Basket::instance();
    
    $this->_view->count = $basket->get_count_items();
    $this->_view->price = $basket->get_items_price(TRUE);
  }
}
