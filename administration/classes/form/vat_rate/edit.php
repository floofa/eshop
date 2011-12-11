<?php defined('SYSPATH') or die('No direct script access.');

class Form_Vat_Rate_Edit extends Forms_List
{
  public function build()
  {
    $this->group('group1');
    $this->col('col1')
      ->add('name');
    
    $this->col('col2')
      ->add('value');
  }
  
  public function set_rules()
  {
    $this->rules('name', array (
      array ('not_empty'),
      array ('max_length', array (':value', 50)),
    ));
    
    $this->rules('value', array (
      array ('not_empty'),
      array ('numeric', array (':value')),
    ));
  }
}
