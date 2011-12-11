<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product extends ORM 
{
  protected $_belongs_to = array ('product_category' => array (), 'vat_rate' => array ());
  
  public function __get($column)
  {
    switch ($column) {
      case 'price':
        return (Kohana::$config->load('cms.eshop.display_price_with_vat')) ? $this->price_final_with_vat : $this->price_final_without_vat;
    }
    
    /*
    switch ($column) {
      case 'price_with_curr' :
        return $this->price . ',- Kč';
      case 'price_final_with_curr' :
        return $this->price_final . ',- Kč';
      case 'in_discount':
        return ($this->price_final < $this->price);
    }
    */
    
    return parent::__get($column);
  }
  
  public function set_show_conditions()
  {
    return $this->where('cms_status', '=', 1);
  }
  
  /**
  * zjisti, jestli je mozno pridat produkt do kosiku
  */
  public function allowed_add_to_basket()
  {
    return $this->cms_status;
  }
  
  public function get_count_all()
  {
    return $this->count_all();
  }
  
  public function list_all($limit = FALSE, $offset = FALSE)
  {
    if ($limit !== FALSE)
      $this->limit($limit)->offset($offset);
      
    return $this->find_all();
  }
  
  public function get_url()
  {
    return Route::url('products-detail', array ('rew_id' => $this->rew_id));
  }

  /**
  * vrati mppt kategorie produktu
  */
  public function get_mptt_categories()
  {
    $category = ORM::factory('product_categorymptt', $this->product_category_id);
    
    if ($category->loaded())
      return $category->parents(FALSE, TRUE);
      
    return array ();
  }
  
  public function get_categories()
  {
    $res = array ();
    $mptt_category = ORM::factory('product_categorymptt', $this->product_category_id);
    
    if ($mptt_category->loaded()) {
      foreach ($mptt_category->get_parents(FALSE, TRUE) as $mptt_category) {
        $res[$mptt_category->id] = ORM::factory('product_category', $mptt_category->id);
      }
    }
    
    return $res;
  }
}
