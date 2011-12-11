<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Vat_Rate extends ORM_Classic 
{
  protected $_has_many = array ('products' => array ());
  
  protected $_sorting = array ('sequence' => 'DESC');
  
  public function __get($column)
  {
    switch ($column) {
      case 'value' :
        list($decimal) = array_values(localeconv());
        return (str_replace('.', $decimal,  parent::__get($column)));
    }
    
    return parent::__get($column);
  }
  
  public function rules()
  {
    return array(
      'name' => array(
        array('not_empty'),
        array('max_length', array(':value', 50)),
      ),
    );
  }
  
  public function save(Validation $validation = NULL)
  {
    $this->set_coefficients();
    
    return parent::save($validation);
  }
  
  public function set_coefficients()
  {
    $this->coefficient_with_vat = round($this->value / 100, 2);
    $this->coefficient_without_vat = round($this->value / (100 + $this->value), 4);
  }
  
  /**
  * vypocte cenu bez DPH
  * 
  * @param mixed $price_with_vat
  * @return float
  */
  public function calculate_price_without_vat($price_with_vat)
  {
    $vat = $price_with_vat * $this->coefficient_without_vat;
    return round($price_with_vat - $vat, 2);
  }
  
  /**
  * vypocte cenu s DPH
  * 
  * @param mixed $price_with_vat
  * @return float
  */
  public function calculate_price_with_vat($price_without_vat)
  {
    $vat = $price_without_vat * $this->coefficient_with_vat;
    return round($price_without_vat + $vat, 2);
  }
}