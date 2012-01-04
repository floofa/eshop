<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product_Category extends ORM 
{
  public function get_descendants_ids()
  {
    $res = array ();
    
    foreach (ORM::factory('product_category')->where('parent_id', '=', $this->id)->where('cms_status', '=', 1)->find_all() as $child) {
      $res[$child->id] = $child->id;
      $res += $child->get_descendants_ids();
    }
    
    return $res;
  }
  
  public function get_url($protocol = NULL)
  {
    $full_rew_id = ORM::factory('product_categorymptt', $this->id)->get_uri();
    
    return Route::url('products-list', array ('rew_id' => $full_rew_id), $protocol);
  }
  
  /**
  * vrati id potomku
  * 
  */
  /*
  public function get_children_ids($depth = FALSE, $actual_depth = 0)
  {
    $actual_depth++;
    
    if ($depth && $actual_depth > $depth)
      return array ();
    
    if ($this->loaded()) {
      $parent_id = $this->id;
    }
    else {
      $parent_id = 1;
    }
    
    $ids = array ();
    
    foreach (ORM::factory('product_category')->where('parent_id', '=', $parent_id)->where('cms_status', '=', 1)->find_all() as $category) {
      $ids[$category->id] = $category->id;
      
      $ids += $category->get_children_ids($depth, $actual_depth);
    }
    
    return $ids;
  }
  
  public function get_childrens()
  {
    return ORM::factory('product_category')->where('parent_id', '=', $this->id)->where('cms_status', '=', 1)->find_all();
  }
  
  public function get_uri()
  {
    return ORM::factory('product_categorymptt', $this->id)->get_uri();
  }
  */
}
