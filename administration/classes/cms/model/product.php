<?php defined('SYSPATH') or die('No direct access allowed.');

class Cms_Model_Product extends ORM_Classic 
{
  protected $_belongs_to = array ('product_category' => array (), 'vat_rate' => array ());
  
  protected $_filter_as_like = array ('name', 'code');
  
  protected $_form_numeric_fields = array ('price_without_vat');
  
  public function __get($column)
  {
    switch ($column) {
      case 'price_final' :
        return (Kohana::$config->load('cms.eshop.displayed_price_with_vat')) ? $this->price_final_with_vat : $this->price_final_without_vat;
    }
    
    return parent::__get($column);
  }
  
  public function as_form_array()
  {
    $values = parent::as_form_array();
    
    list($decimal) = array_values(localeconv());
    $values['price_without_vat'] = str_replace('.', $decimal,  $values['price_without_vat']);
    
    return $values;
  }
  
  public function rules()
  {
    return array(
      'name' => array(
        array('not_empty'),
      ),
      'rew_id' => array(
        array('not_empty'),
      ),
    );
  }
  
  public function set_list_filters()
  {
    foreach ($this->_list_where as $where) {
      if ($where[0] == 'product_category_id') {
        $this->where($where[0], 'IN', ORM::factory('product_categorymptt', $where[2])->get_descendants(TRUE)->as_array('id', 'id'));
      }
      else
        $this->where($where[0], $where[1], $where[2]);
    }
    
    return $this;
  }
  
  public function set_list_item_default(&$arr, $item) 
  {
    $arr['price'] = $item->price_final . ',- Kč';
    $arr['discount'] = (($item->discount) ? $item->discount . ',- Kč' : (($item->discount_perc) ? $item->discount_perc . '%' : ''));
    $arr['cms_status'] = ($item->cms_status) ? ___('basic_yes') : ___('basic_no');
  }
  
  public function save(Validation $validation = NULL)
  {
    // nastavi cenu s DPH / bez DPH - v zavislosti na konfiguraci
    if (Kohana::$config->load('cms.eshop.calculate_price_without_vat'))
      $this->set_price_without_vat();
    else
      $this->set_price_with_vat();
    
    // nastavi finalni cenu
    $this->set_final_price();
    
    return parent::save($validation);
  }
  
  /**
  * vypocte cenu s DPH
  * 
  */
  public function set_price_with_vat()
  {
    $this->price_with_vat = $this->vat_rate->calculate_price_with_vat($this->price_without_vat);
    
    return $this;
  }
  
  /**
  * vypocte cenu bez DPH
  */
  public function set_price_without_vat()
  {
    $this->price_without_vat = $this->vat_rate->calculate_price_without_vat($this->price_with_vat);
    
    return $this;
  }
  
  /**
  * vypocte konecnou cenu
  * 
  */
  public function set_final_price()
  {
    $this->discount;
    
    if ( ! $this->discount && $this->discount_perc) {
      $this->discount = round((Kohana::$config->load('cms.eshop.calculate_price_without_vat') ? $this->price_with_vat : $this->price_without_vat) / 100 * $this->discount_perc, 0);
    }
    
    if ( ! $this->discount) {
      $this->price_final_without_vat = $this->price_without_vat;
      $this->price_final_with_vat = $this->price_with_vat;
    }
    else {
      if (Kohana::$config->load('cms.eshop.calculate_price_without_vat')) {
        $this->price_final_with_vat = $this->price_with_vat - $this->discount;
        $this->price_final_without_vat = $this->vat_rate->calculate_price_without_vat($this->price_final_with_vat);
      }
      else {
        $this->price_final_without_vat = $this->price_without_vat - $this->discount;
        $this->price_final_with_vat = $this->vat_rate->calculate_price_with_vat($this->price_final_without_vat);
      }
    }
    
    return $this;
  }
  
  /**
  * overi, jestli existuje produkt se zadanym kodem
  */
  public static function exists_product_with_code($code)
  {
    return ORM::factory('product')->where('code', '=', $code)->find()->loaded();
  }
}
