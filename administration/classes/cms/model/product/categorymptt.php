<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product_CategoryMPTT extends ORM_MPTT_Classic
{
  protected $_save_gallery = FALSE;
  
  public $_table_name = 'product_categories';
  
  public $scope_column = 'scope';
  
  public function set_unique_value($field, $value, $sep = '-')
  {
    if (strlen($value)) {
      $tvalue = $value;
        
      for ($x = 1; ORM::factory($this->_object_name)->where($field, '=', $value)->where('parent_id', '=', $this->parent_id)->where('id', '!=', $this->id)->find()->id; $x++)
        $value = $tvalue . '-' . $x;
    }
    
    return $value;
  }
  
  
  /**
  * vrati posledni kategorie
  */
  public function select_list_last($value = '')
  {
    if ( ! $this->loaded())
      return $this->get_root(1)->select_list_last();
    
    if ($this->lvl > 1)
      $value .= ((strlen($value)) ? ' > ' : '') . $this->name;
    
    $children = $this->children;
    
    $arr = array ();
    
    if (count($children)) {
      foreach ($children as $child) {
        $arr += $child->select_list_last($value);
      }
    }
    elseif ($this->lvl > 1) {
      $arr[$this->id] = $value;
    }
    
    return $arr;
  }
  
  
  public function select_list_product($all_categories = FALSE, &$arr = array (), $value = '')
  {
    $children = $this->children;
    
    if ($this->lvl)
      $value .= ((strlen($value)) ? ' > ' : '') . $this->name;
    
    if (count($children)) {
      foreach ($children as $child) {
        if ($all_categories && $this->lvl) {
          $arr[$this->id] = $value;
        }
        
        $child->select_list_product($all_categories, $arr, $value);
      }                                                                                  
    }
    else {
      $arr[$this->id] = $value;
    }
    
    return $arr;
  }
  
  public function set_list_item_default(&$arr, $item) 
  {
    $arr['cms_status'] = ($item->cms_status) ? ___('basic_yes') : ___('basic_no');
  }

}