<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product_News extends ORM 
{
  protected $_table_names_plural = FALSE;
  
  protected $_belongs_to = array ('product' => array ());
  
  protected $_sorting = array ('sequence' => 'DESC');
}