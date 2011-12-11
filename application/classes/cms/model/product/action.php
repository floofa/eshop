<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product_Action extends ORM 
{
  protected $_belongs_to = array ('product' => array ());
  
  protected $_sorting = array ('sequence' => 'DESC');
}