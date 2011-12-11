<?php defined('SYSPATH') or die('No direct script access.');

class Cms_Controller_Product_Categories extends Controller_Builder_Template_Administration_Classic_Tree
{                 
  protected $_model_mptt = 'product_categorymptt';
  
  protected $_list_actions = array ('list' => TRUE, 'edit' => TRUE, 'delete' => TRUE);
  protected $_list_row_action = 'list';
}

