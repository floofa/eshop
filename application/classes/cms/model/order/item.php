<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Order_Item extends ORM 
{
  protected $_belongs_to = array ('product' => array ());
  
  public function __get($column)
  {
    switch ($column) {
      case 'total_price' :
        return $this->get_total_price();
      case 'total_price_without_vat' :
        return $this->get_total_price(FALSE);
    }
    
    return parent::__get($column);
  }
  
  public function set_product($product)
  {
    // chceme ziskat nazvy v hlavnim jazyce
    $product->multilang_fields_enabled = FALSE;
    
    $this->product_id = $product->id;
    $this->code = $product->code;
    $this->name = $product->name;
    $this->price_with_vat = $product->price_final_with_vat;
    $this->price_without_vat = $product->price_final_without_vat;
    $this->vat_rate = $product->vat_rate->value;
    
    return $this;
  }
  
  public function get_total_price($with_vat = TRUE)
  {
    $column = ($with_vat) ? 'price_with_vat' : 'price_without_vat';
    
    return $this->{$column} * $this->count;
  }
  
  public function get_vat()
  {
    return $this->price_without_vat / 100 * (100 + $this->vat_rate) - $this->price_without_vat;
      
    return $vat;
  }
  
  public function get_total_vat()
  {
    return $this->get_vat() * $this->count;
  }
}