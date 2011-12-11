<?php defined('SYSPATH') or die('No direct script access.');

class Form_Purchase_Personal_Data extends Forms
{
  public function build()
  {
    $this->add('name');
    $this->add('surname');
    $this->add('street');
    $this->add('city');
    $this->add('postcode');
    $this->add('email');
    $this->add('phone');
    
    $this->add('company_data', 'bool');
    $this->add('company');
    $this->add('cin');
    $this->add('tin');
    
    $this->add('delivery_address', 'bool');
    $this->add('delivery_company');
    $this->add('delivery_name');
    $this->add('delivery_surname');
    $this->add('delivery_street');
    $this->add('delivery_city');
    $this->add('delivery_postcode');
    $this->add('delivery_phone');
    
    if (Kohana::$config->load('cms.eshop.signup_newsletter_enabled')) {
      $this->add('signup_newsletter', 'bool', TRUE);
      $this->_data['signup_newsletter_enabled'] = TRUE;
    }
    
    $this->add('license_terms', 'bool');
  }
  
  public function set_rules()
  {
    // fakturacni udaje
    $this->rules('name', array (
      array ('not_empty'),
      array ('max_length', array (':value', 30)),
    ));
    
    $this->rules('surname', array (
      array ('not_empty'),
      array ('max_length', array (':value', 30)),
    ));
    
    $this->rules('street', array (
      array ('not_empty'),
      array ('max_length', array (':value', 50)),
    ));
    
    $this->rules('city', array (
      array ('not_empty'),
      array ('max_length', array (':value', 50)),
    ));
    
    $this->rules('postcode', array (
      array ('not_empty'),
      array ('max_length', array (':value', 10)),
    ));
    
    $this->rules('email', array (
      array ('not_empty'),
      array ('email', array (':value')),
      array ('max_length', array (':value', 127)),
    ));
    
    $this->rules('phone', array (
      array ('not_empty'),
      array ('max_length', array (':value', 20)),
    ));
    
    // dorucovaci udaje
    $this->rules('delivery_name', array (
      array ('max_length', array (':value', 30)),
    ));
    
    $this->rules('delivery_surname', array (
      array ('max_length', array (':value', 30)),
    ));
    
    $this->rules('delivery_street', array (
      array ('max_length', array (':value', 50)),
    ));
    
    $this->rules('delivery_city', array (
      array ('max_length', array (':value', 50)),
    ));
    
    $this->rules('delivery_postcode', array (
      array ('max_length', array (':value', 10)),
    ));
    
    $this->rules('delivery_phone', array (
      array ('max_length', array (':value', 20)),
    ));
    
    // firemni udaje
    $this->rules('company', array (
      array ('max_length', array (':value', 50)),
    ));
    
    $this->rules('cin', array (
      array ('max_length', array (':value', 20)),
    ));
    
    $this->rules('tin', array (
      array ('max_length', array (':value', 20)),
    ));
    
    // licencni podminky
    $this->rule('license_terms', 'checked', array (':value'));
    
    // specialni pravidla
    if ($_POST) {
      // firemni udaje
      if (isset($_POST[$this->get_form_name()]['company_data']) && $_POST[$this->get_form_name()]['company_data']) {
        $this->rule('company', 'not_empty');
      }
      
      // dorucovaci udaje
      if (isset($_POST[$this->get_form_name()]['delivery_address']) && $_POST[$this->get_form_name()]['delivery_address']) {
        $this->rule('delivery_name', 'not_empty');
        $this->rule('delivery_surname', 'not_empty');
        $this->rule('delivery_street', 'not_empty');
        $this->rule('delivery_city', 'not_empty');
        $this->rule('delivery_postcode', 'not_empty');
      }
    }
  }
  
  public function do_form($values = array (), $refresh = FALSE, $redirect = TRUE)
  {
    $purchase = Session::instance()->get('purchase');
    $purchase['personal_data'] = $values;
    
    Session::instance()->set('purchase', $purchase);
    
    Request::redirect_initial(Route::get('purchase-summary')->uri());
  }
}
