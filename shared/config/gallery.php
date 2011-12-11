<?php defined('SYSPATH') or die('No direct access allowed.');

// Paths to media relative to DOCROOT

// kategorie
$config['product_category_images']['file_size_limit'] = '2MB';
$config['product_category_images']['file_types'] = '*.jpg;*.jpeg;*.png;*.gif;*.bmp';
$config['product_category_images']['file_types_desc'] = 'Obrázky';

$config['thumbs']['product_category_images'] = array (
  's'   => array ('width' => 100, 'height' => 100),
);

// produkty
$config['product_images']['file_size_limit'] = '5MB';
$config['product_images']['file_types'] = '*.jpg;*.jpeg;*.png;*.gif;*.bmp';
$config['product_images']['file_types_desc'] = 'Obrázky';

$config['thumbs']['product_images'] = array (
  'm' => array ('width' => 300, 'height' => 300),
  's' => array ('width' => 100, 'height' => 100),
);

return $config;

