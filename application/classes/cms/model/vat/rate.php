<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Vat_Rate extends ORM 
{
  protected $_has_many = array ('products' => array ());
  
  protected $_sorting = array ('sequence' => 'DESC');
}