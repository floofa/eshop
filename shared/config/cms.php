<?php defined('SYSPATH') or die('No direct access allowed.');

return array (
  'eshop' => array (
    // TRUE - dopocitat cenu bez DPH, FALSE - dopocita cenu s DPH
    'calculate_price_without_vat' => TRUE,
    
    // zobrazovana cena je s DPH
    'display_price_with_vat' => TRUE,
    
    // doprava zdarma
    'free_delivery' => 1500,
    
    // input pro prihlaseni k newletteru pri objednavce
    'signup_newsletter_enabled' => FALSE,
    
    // automaticke prepocitavani kusu skladem
    'auto_manipulation_with_stock' => FALSE,
  )
);

return $config;