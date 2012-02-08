<?php defined('SYSPATH') or die('No direct script access.');

return array
(
  // plural
  'items' => array (
    'one' => ':count položka',
    'few' => ':count položky',
    'other' => ':count položek',
  ),

  // nakup - osobni udaje
  'form_purchase_personal_data_field_name' => 'Jméno',
  'form_purchase_personal_data_field_surname' => 'Příjmení',
  'form_purchase_personal_data_field_street' => 'Ulice',
  'form_purchase_personal_data_field_city' => 'Město',
  'form_purchase_personal_data_field_postcode' => 'PSČ',
  'form_purchase_personal_data_field_email' => 'E-mail',
  'form_purchase_personal_data_field_phone' => 'Telefon',
  'form_purchase_personal_data_field_company_data' => 'Nakupuji na firmu',
  'form_purchase_personal_data_field_company' => 'Firma',
  'form_purchase_personal_data_field_cin' => 'IČ',
  'form_purchase_personal_data_field_tin' => 'DIČ',
  'form_purchase_personal_data_field_delivery_address' => 'Zboží chci doručit na jinou adresu',
  'form_purchase_personal_data_field_delivery_company' => 'Firma',
  'form_purchase_personal_data_field_delivery_name' => 'Jméno',
  'form_purchase_personal_data_field_delivery_surname' => 'Příjmení',
  'form_purchase_personal_data_field_delivery_street' => 'Ulice',
  'form_purchase_personal_data_field_delivery_city' => 'Město',
  'form_purchase_personal_data_field_delivery_postcode' => 'PSČ',
  'form_purchase_personal_data_field_delivery_phone' => 'Telefon',
  'form_purchase_personal_data_field_license_terms' => 'Souhlasím s licenčními podmínkami',
  'form_purchase_personal_data_field_signup_newsletter' => 'Přihlásit se k odběru newsletteru',
  

  'validate' => array (
    'order_payment_method_id' => array (
      'has_delivery_method' => 'Zvolený způsob platby nemůže být použit se zvoleným způsobem dopravy',
    ),
    'license_terms' => array (
      'checked' => 'Nebyl vyplněn souhlas s licenčními podmínkami',
    ),
  ),
);
