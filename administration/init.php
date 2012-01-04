<?php defined('SYSPATH') or die('No direct script access.');



/* detail produktu */
Route::set('orders_items', 'eshop/orders/edit/<id>/<action>/<item_id>', array (
    'action' => '(edit_item|delete_item)',
  ))
  ->defaults(array(
    'controller'  => 'orders',
  ));
  



