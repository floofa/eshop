<?php defined('SYSPATH') or die('No direct script access.');

abstract class Cms_Controller_Products extends Controller_Builder_Template_Application
{
  /**
  * vypis produktu z kategorie
  */
  public function action_list()
  {
    $rew_ids = array ();
    
    if (strlen(($rew_id = $this->request->param('rew_id'))))
      $rew_ids = explode('/', $rew_id);
    
    $categories = array ();
    
    foreach ($rew_ids as $key => $rew_id) {
      $lvl = $key + 2;
      
      $category = ORM::factory('product_category')->where('rew_id', '=', $rew_id)->where('lvl', '=', $lvl)->where('cms_status', '=', 1)->find();
      
      if ( ! $category->loaded())
        throw new Kohana_HTTP_Exception_404('Your requested product category `:category` not found.', array (':category' => $this->request->param('rew_id')));
      
      if (count($categories) && $prev_category = end($categories)) {
        if ($category->parent_id != $prev_category->id) {
          throw new Kohana_HTTP_Exception_404('Your requested category :category not found.', array (':category' => $this->request->param('rew_id')));
        }
      }
      
      $categories[ ] = $category;
    }
    
    if ( ! count($categories))
      $this->_list_index();
    else 
      $this->_list($categories);
  }
  
  /**
  * vypis ze vsech kategorii
  */
  protected function _list_index()
  {
    $this->request->redirect('');
  }
  
  /**
  * vypis z konkretni kategorie
  */
  protected function _list($categories)
  {
    // aktualni kategorie
    $category = end($categories);
    
    // hlavicka
    Head::set_arr($category->as_array());
    Head::set('head_title', $category->name);
    
    // drob. navigace
    $this->_set_navigation($categories);
    
    // id vsech kategorii, jejichz produkty mohou byt zobrazeny
    $allowed_categories_ids = array($category->id => $category->id) + $category->get_descendants_ids();
    
    // produkty
    $pagination = Pagination::factory(array ('group' => 'products', 'total_items' => ORM::factory('product')->where('product_category_id', 'IN', $allowed_categories_ids)->set_show_conditions()->get_count_all()));
    $products = ORM::factory('product')->where('product_category_id', 'IN', $allowed_categories_ids)->set_show_conditions()->list_all($pagination->items_per_page, $pagination->offset);
    
    $this->_view->set('category', $category)
                ->set('category_link', Route::url('products-list', array ('rew_id' => $this->request->param('rew_id')), TRUE))
               ->set('categories', $categories)
               ->set('products', $products)
               //->set('subcategories', $subcategories)
               ->set('pagination', $pagination);
  }
  
  protected function _set_navigation($categories, $product = FALSE)
  {
    $uri = '';
    
    foreach ($categories as $category) {
      $uri .= ((strlen($uri)) ? '/' : '') . $category->rew_id;
      Navigation::add($category->name, Route::url('products-list', array ('rew_id' => $uri)));
    }
    
    if ($product !== FALSE)
      Navigation::add($product->name, $product->get_url());
  }
  
  /**
  * HMVC - produkt pro vypis produktu
  */
  public function action_list_product()
  {
    $this->_view->product = ORM::factory('product', $this->request->param('id'));
    $this->_view->last = $this->request->param('last', 0);
  }
  
  public function action_get()
  {
    $product = ORM::factory('product')->where('rew_id', '=', $this->request->param('rew_id'))->find();
    
    if ( ! $product->loaded() || ! $product->cms_status || ! $product->product_category_id)
      throw new Kohana_HTTP_Exception_404('Requested product `:product` not found.', array (':product' => $this->request->param('rew_id')));
    
    $categories = $product->get_categories();
    
    // hlavicka
    Head::set_arr($product->as_array());
    Head::set('head_title', $product->name);
    
    // drob. navigace
    $this->_set_navigation($categories, $product);
    
    $this->_view->set('product', $product)
                ->set('product_images', $product->get_gallery_items())
                ->set('categories', $categories)
                ->set('similar_products', $product->get_similar_products());
    
    
  }
  
  
  
  /*
  public function action_get()
  {
    $product = ORM::factory('product')->where('rew_id', '=', $this->request->param('rew_id'))->find();
    
    if ( ! $product->loaded() || ! $product->cms_status || ! $product->product_category_id)
      throw new Kohana_HTTP_Exception_404_Sub('Unable to find product :product.', array (':product' => $this->request->param('rew_id')));
      
    $mptt_categories = $product->get_mptt_categories();
      
    // naviagace
    $this->set_navigation($product, $mptt_categories);
    
    Head::set_arr($product->as_array());
    Head::set('head_title', $product->name);
    
    // aktivace polozky v menu kategorii
    $this->set_category_menu_active_link($mptt_categories);
      
    $this->view->set('product', $product);
  }
  
  protected function set_navigation($product, $categories)
  {
    $uri = '';
    
    foreach ($categories as $category) {
      $uri .= ((strlen($uri)) ? '/' : '') . $category->rew_id;
      Navigation::add($category->name, Linker::get('kategorie', $uri));
    }
    
    Navigation::add($product->name, Linker::get('produkty', $product->rew_id));
  }
  
  protected function set_category_menu_active_link($categories)
  {
    $uri = '';
    
    foreach ($categories as $category) {
      $uri .= ((strlen($uri)) ? '/' : '') . $category->rew_id;
    }
    
    Variables::set('categories_menu_active_link', Linker::get('kategorie', $uri));
  }
  */
}