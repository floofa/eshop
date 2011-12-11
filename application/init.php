<?php defined('SYSPATH') or die('No direct script access.');

/*** NAKUP ***/

// nakup - potvrzeni nakupu
Route::set('purchase-done', 'nakup/hotovo/<order_id>/<hash>')
  ->defaults(array(
    'controller'  => 'purchase',
    'action'      => 'done',
  ));

// nakup - objednani zbozi
Route::set('purchase-buy', 'nakup/objednat')
  ->defaults(array(
    'controller'  => 'purchase',
    'action'      => 'buy',
  ));

// nakup - shrnuti objednavky
Route::set('purchase-summary', 'nakup/shrnuti')
  ->defaults(array(
    'controller'  => 'purchase',
    'action'      => 'summary',
  ));

// nakup - osobni udaje
Route::set('purchase-personal_data', 'nakup/osobni-udaje')
  ->defaults(array(
    'controller'  => 'purchase',
    'action'      => 'personal_data',
  ));

// nakup - zpusob dopravy a platby
Route::set('purchase-delivery_and_payment', 'nakup/doprava-a-platba')
  ->defaults(array(
    'controller'  => 'purchase',
    'action'      => 'delivery_and_payment',
  ));


/*** KOSIK ***/

/* odebrani zbozi do kosiku */
Route::set('basket-remove_item', 'kosik/odebrat/<key>')
  ->defaults(array(
    'controller'  => 'basket',
    'action'      => 'remove_item',
  ));

/* pridani zbozi do kosiku */
Route::set('basket-add_item', 'kosik/vlozit/<rew_id>(/<count>)')
  ->defaults(array(
    'controller'  => 'basket',
    'action'      => 'add_item',
    'count'       => 1,
  ));
  
/* zobrazeni kosiku */
Route::set('basket', 'kosik')
  ->defaults(array(
    'controller'  => 'basket',
    'action'      => 'index',
  ));

/*** PRODUKTY ***/

/* blok - produkt ve vypise produktu */
Route::set('products-block_list_product', 'produkty/list_product/<id>(/<last>)')
  ->defaults(array(
    'controller'  => 'products',
    'action'      => 'list_product',
  ));

/* vypis produktu */
Route::set('products-list', 'kategorie(/<rew_id>)', array('rew_id' => '.*'))
  ->defaults(array(
    'controller'  => 'products',
    'action'      => 'list',
  ));

/* detail produktu */
Route::set('products-detail', 'produkty/<rew_id>')
  ->defaults(array(
    'controller'  => 'products',
    'action'      => 'get',
  ));
  



