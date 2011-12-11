<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product_Category extends ORM_Classic 
{
  protected $rew_id_set = FALSE;
  
  public function set_unique_value($field, $value, $sep = '-')
  {
    if (strlen($value)) {
      $tvalue = $value;
        
      for ($x = 1; ORM::factory($this->_object_name)->where($field, '=', $value)->where('parent_id', '=', $this->parent_id)->where('id', '!=', $this->id)->find()->id; $x++)
        $value = $tvalue . '-' . $x;
    }
    
    return $value;
  }
  
  public function list_all($count = FALSE, $offset = FALSE)
  {
    $this->list_where[ ] = array ('scope', '=', '1');
    
    return parent::list_all($count, $offset);
  }
  
  public function set_list_item_default(&$arr, $item) 
  {
    $arr['cms_status'] = ($item->cms_status) ? ___('basic_yes') : ___('basic_no');
  }
}
