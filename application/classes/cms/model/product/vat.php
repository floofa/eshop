<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product_Vat extends ORM 
{
  protected $_has_many = array ('products' => array ());
}