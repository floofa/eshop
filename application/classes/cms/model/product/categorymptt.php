<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product_CategoryMPTT extends ORM_MPTT
{
  protected $_table_name = 'product_categories';
  
  protected $_scope_value = 1;
 
 /* 
  public function get_root_id()
  {
    if ($this->lvl == 1)
      return $this->id;
    
    $parent = $this->parent;
    
    if ($parent->loaded())
      return $this->parent->get_root_id();
    
    return NULL;
  }
  
  public function select_list_product(&$arr = array (), $value = '')
  {
    $children = $this->children;
    
    if ($this->lvl)
      $value .= ((strlen($value)) ? ' > ' : '') . $this->name;
    
    if (count($children)) {
      foreach ($children as $child) {
        $child->select_list_product($arr, $value);
      }                                                                                  
    }
    else {
      $arr[$this->id] = $value;
    }
    
    return $arr;
  }
  
  public static function get_not_show_ids()
  {
    $ids = array ();

    foreach (ORM::factory('product_categorymptt')->where('cms_status', '=', 0)->find_all() as $category) {
      if ($category->is_root())
        continue;

      $ids[$category->id] = $category->id;

      // pridaji se i vsechny podkategorie
      foreach ($category->descendants as $child) {
        $ids[$child->id] = $child->id;
      }
    }

    return $ids;
  }
  */
  
  public function get_uri()
  {
    $rew_ids = $this->get_parents(FALSE)->as_array('id', 'rew_id');
    array_push($rew_ids, $this->rew_id);
    
    return implode('/', $rew_ids);
  }
  
}