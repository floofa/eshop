<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product_News extends ORM_Classic 
{
  protected $_table_names_plural = FALSE;
  protected $_belongs_to = array ('product' => array ());
  protected $_sorting = array ('sequence' => 'DESC');
  
  public function set_list_item_default(&$arr, $item) 
  {
    $arr['product_code'] = $item->product->code;
    $arr['product_name'] = $item->product->name;
    $arr['cms_status'] = ($item->cms_status) ? ___('basic_yes') : ___('basic_no');
  }
  
  public function get_navigation_val()
  {
    return $this->product->name;
  }
}