<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Eshop
{
  /**
  * zjisti, jestli zakaznik dosahl dopravy zdarma
  * 
  * FALSE - doprava zdarma zakazana
  * TRUE - doprava zdarma dosazena
  * ciselna hodnota - kolik zbyva k dosazeni dopravy zdarma
  */
  public static function has_free_delivery()
  {
    $free_delivery = Kohana::$config->load('cms.eshop.free_delivery');
    
    if ($free_delivery === FALSE)
      return FALSE;
      
    $price = Basket::instance()->get_items_price();
      
    if ($price >= $free_delivery)
      return TRUE;
      
    return $free_delivery - $price;
  }
}
