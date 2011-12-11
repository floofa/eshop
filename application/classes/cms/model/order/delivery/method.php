<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Order_Delivery_Method extends ORM 
{
  protected $_belongs_to = array ('vat_rate' => array ());
  protected $_has_many = array ('order_payment_methods' => array ('model' => 'order_payment_method', 'through' => 'order_delivery_methods_order_payment_methods'));
  protected $_sorting = array ('sequence' => 'DESC');
}
