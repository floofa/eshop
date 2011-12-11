<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Order_Delivery_Method extends ORM_Classic 
{
  protected $_belongs_to = array ('vat_rate' => array ());
  protected $_has_many = array ('order_payment_methods' => array ('model' => 'order_payment_method', 'through' => 'order_delivery_methods_order_payment_methods'));
  protected $_sorting = array ('sequence' => 'DESC');
  
  public function set($column, $value)
  {
    switch ($column) {
      case 'sys_name':
        if ( ! strlen($value)) {
          $value = NULL;
        }
        else {
          $value = url::title($value, '_', TRUE);
        }
        break;
    }
  
    return parent::set($column, $value);
  }
  
  public function set_list_item_default(&$arr, $item) 
  {
    $arr['price'] = $item->price_with_vat . ',- Kč';
    $arr['cms_status'] = ($item->cms_status) ? ___('basic_yes') : ___('basic_no');
  }
  
  public function save(Validation $validation = NULL)
  {
    // nastavi cenu bez DPH
    $this->set_price_without_vat();
    
    return parent::save($validation);
  }
  
  /**
  * vypocte cenu bez DPH
  */
  public function set_price_without_vat()
  {
    $this->price_without_vat = $this->vat_rate->calculate_price_without_vat($this->price_with_vat);
    
    return $this;
  }
}
