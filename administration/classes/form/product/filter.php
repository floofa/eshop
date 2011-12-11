<?php defined('SYSPATH') or die('No direct script access.');

class Form_Product_Filter extends Forms_Filter
{
  public function build()
  {
    $this->group('group1')
      ->add('code')
      ->add('name')
      ->add('product_category_id', 'select', array ('options' => array ('' => '--- Vybrat ---') + ORM::factory('product_categorymptt')->select_list_last(TRUE)));
  }
}
