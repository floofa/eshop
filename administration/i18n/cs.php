<?php defined('SYSPATH') or die('No direct script access.');

return array
(
  'cms_menu_eshop_module' => 'Eshop',
  'cms_menu_eshop_module_orders' => 'Objednávky',
  'cms_menu_eshop_module_order_delivery_methods' => 'Způsoby dodání',
  'cms_menu_eshop_module_order_payment_methods' => 'Způsoby plateb',
  
  'cms_menu_eshop_module_products' => 'Produkty',
  'cms_menu_eshop_module_product_categories' => 'Kategorie produktů',
  'cms_menu_eshop_module_vat_rates' => 'Sazby DPH',
  'cms_menu_eshop_module_product_recomended' => 'Doporučené produkty',
  'cms_menu_eshop_module_product_news' => 'Nové produkty',
  
  'navigation_section_eshop' => 'Eshop',
  
  'navigation_orders' => 'Objednávky',
  'navigation_orders_edit_customer' => 'Editace objednatele',
  'navigation_orders_show' => 'Detail',
  'navigation_products' => 'Produkty',
  'navigation_categories' => 'Kategorie',
  'navigation_vat_rates' => 'Sazby DPH',
  'navigation_product_categories' => 'Kategorie produktů',
  'navigation_product_recomended' => 'Doporučené produkty',
  'navigation_product_news' => 'Nové produkty',
  'navigation_order_delivery_methods' => 'Způsoby dodání',
  'navigation_order_payment_methods' => 'Způsoby plateb',
  
  
  'bookmarks_order_show' => 'Detail objednávky',
  'bookmarks_order_edit' => 'Editace objednávky',
  'bookmarks_order_edit_customer' => 'Editace objednatele',
  'bookmarks_order_orders_payments' => 'Přijaté platby',
  
  // typy plateb
  'payment_types' => array (
    'delivery' => 'Dobírka',
    'bank_transfer' => 'Bankovní převod',
    'cash' => 'Hotově',
  ),
  
  
  // products categories
  'list_tree_product_category_heading' => 'Kategorie produktů',
  'list_tree_product_category_new_button' => 'Nová kategorie',
  'list_tree_product_category_fields' => array ('name' => 'Název'),
  'list_tree_product_category_secondary_fields' => array ('cms_status' => 'Zobrazit'),
  
  // products
  'list_product_heading' => 'Produkty',
  'list_product_new_button' => 'Nový produkt',
  'list_product_fields' => array ('code' => 'Kód', 'name' => 'Název', 'count_stock' => 'Počet skladem', 'price' => 'Prodejní cena', /*'discount' => 'Sleva',*/ 'cms_status' => 'Zobrazit'),
  
  // products vats
  'list_vat_rate_heading' => 'Sazby DPH',
  'list_vat_rate_new_button' => 'Nová sazba',
  'list_vat_rate_fields' => array ('name' => 'Název', 'value' => 'Hodnota [%]'),
  
  // objednavky
  'list_order_heading' => 'Objednávky',
  'list_order_fields' => array ('id' => 'ID', 'date' => 'Datum', 'full_name' => 'Zákazník', 'total_price' => 'Cena', 'payment_state' => 'Stav platby', 'state' => 'Stav obj.'),
  
  'orders_states' => array ('0' => 'Nová', '1' => 'Přijatá', '2' => 'Připravena k odeslání', '3' => 'Odeslaná', '4' => 'Zrušená'),
  'orders_payment_states' => array ('0' => 'Nezaplacená', '1' => 'Zaplacená'),
  
  // orders items
  'list_order_item_heading' => 'Položky objednávky',
  'list_order_item_new_button' => 'Přidat položku',
  'list_order_item_fields' => array ('name' => 'Název', 'price' => 'Cena za ks', 'count' => 'Počet ks', 'total_price' => 'Cena celkem'),
  
  // orders sevices
  'list_order_service_heading' => 'Služby',
  'list_order_service_fields' => array ('name' => 'Název', 'price' => 'Cena'),
  
  // orders delivery methods
  'list_order_delivery_method_heading' => 'Způsoby dodání',
  'list_order_delivery_method_new_button' => 'Nový způsob dodání',
  'list_order_delivery_method_fields' => array ('name' => 'Název', 'price' => 'Cena s DPH', 'cms_status' => 'Zobrazit'),
  
  // orders payment methods
  'list_order_payment_method_heading' => 'Způsoby plateb',
  'list_order_payment_method_new_button' => 'Nový způsob platby',
  'list_order_payment_method_fields' => array ('name' => 'Název', 'price' => 'Cena s DPH', 'cms_status' => 'Zobrazit'),
  
  // produkty v akci
  'list_product_recomended_heading' => 'Produkty v akci na HP',
  'list_product_recomended_new_button' => 'Přidat produkt',
  'list_product_recomended_fields' => array ('product_code' => 'Kód produktu', 'product_name' => 'Název produktu', 'cms_status' => 'Zobrazit'),
  
  // nove produkty
  'list_product_news_heading' => 'Nové produkty na HP',
  'list_product_news_new_button' => 'Přidat produkt',
  'list_product_news_fields' => array ('product_code' => 'Kód produktu', 'product_name' => 'Název produktu', 'cms_status' => 'Zobrazit'),
  
  //-------- FORMS ------------ //
  
  // edit product category
  'form_product_category_edit_heading' => 'Editace kategorie produktu',
  'form_product_category_edit_group_product_categories' => 'Obrázek',
  'form_product_category_edit_field_name' => 'Název',
  'form_product_category_edit_field_rew_id' => 'Url',
  'form_product_category_edit_field_cms_status' => 'Zobrazit',
  'form_product_category_edit_field_meta_description' => 'Meta description',
  'form_product_category_edit_field_meta_keywords' => 'Meta keywords',
  'form_product_category_edit_field_description' => 'Popis',
  
  // edit product
  'form_product_edit_heading' => 'Editace produktu',
  'form_product_edit_group_group2' => 'Nastavení ceny',
  'form_product_edit_group_group4' => 'Volby',
  'form_product_edit_group_group3' => 'Ostatní',
  'form_product_edit_group_product_images' => 'Obrázky',
  'form_product_edit_field_name' => 'Název',
  'form_product_edit_field_rew_id' => 'Url',
  'form_product_edit_field_code' => 'Kód produktu',
  'form_product_edit_field_count_stock' => 'Počet ks skladem',
  'form_product_edit_field_product_category_id' => 'Kategorie',
  'form_product_edit_field_vat_rate_id' => 'Sazba DPH',
  'form_product_edit_field_price_without_vat' => 'Cena bez DPH',
  'form_product_edit_field_price_with_vat' => 'Cena s DPH',
  'form_product_edit_field_price_final_with_vat' => 'Konečná cena s DPH',
  'form_product_edit_field_price_final_without_vat' => 'Konečná cena bez DPH',
  'form_product_edit_field_discount' => 'Sleva [Kč]',
  'form_product_edit_field_discount_perc' => 'Sleva [%]',
  'form_product_edit_field_meta_keywords' => 'Meta keywords',
  'form_product_edit_field_meta_description' => 'Meta description',
  'form_product_edit_field_short_description' => 'Krátký popis',
  'form_product_edit_field_description' => 'Dlouhý Popis',
  'form_product_edit_field_cms_status' => 'Zobrazit',
  'form_product_edit_field_disable_ordering' => 'Zakázat objednat',
  
  // edit product vat
  'form_vat_rate_edit_heading' => 'Editace sazby DPH',
  'form_vat_rate_edit_field_name' => 'Název',
  'form_vat_rate_edit_field_value' => 'Hodnota [%]',
  
  // edit product action
  'form_product_recomended_edit_heading' => 'Editace produktu v akci na HP',
  'form_product_recomended_edit_field_product_code' => 'Kód produktu',
  'form_product_recomended_edit_field_product_name' => 'Název produktu',
  'form_product_recomended_edit_field_cms_status' => 'Zobrazit',
  
  // edit product news
  'form_product_news_edit_heading' => 'Editace nového produktu na HP',
  'form_product_news_edit_field_product_code' => 'Kód produktu',
  'form_product_news_edit_field_product_name' => 'Název produktu',
  'form_product_news_edit_field_cms_status' => 'Zobrazit',
  
  // edit orders delivery methods
  'form_order_delivery_method_edit_heading' => 'Editace způsobu dodání',
  'form_order_delivery_method_edit_field_name' => 'Název',
  'form_order_delivery_method_edit_field_sys_name' => 'Systémový název',
  'form_order_delivery_method_edit_field_description' => 'Popis',
  'form_order_delivery_method_edit_field_cms_status' => 'Zobrazit',
  'form_order_delivery_method_edit_field_price_with_vat' => 'Cena s DPH',
  'form_order_delivery_method_edit_field_price_without_vat' => 'Cena bez DPH',
  'form_order_delivery_method_edit_field_vat_rate_id' => 'Sazba DPH',
  
  // edit orders payment methods
  'form_order_payment_method_edit_heading' => 'Editace způsobu platby',
  'form_order_payment_method_edit_field_name' => 'Název',
  'form_order_payment_method_edit_field_sys_name' => 'Systémový název',
  'form_order_payment_method_edit_field_description' => 'Popis',
  'form_order_payment_method_edit_field_cms_status' => 'Zobrazit',
  'form_order_payment_method_edit_field_order_delivery_methods' => 'Povolit u těchto způsobů dopravy',
  'form_order_payment_method_edit_field_payment_type' => 'Typ platby',
  'form_order_payment_method_edit_field_vat_rate_id' => 'Sazba DPH',
  'form_order_payment_method_edit_field_price_with_vat' => 'Cena s DPH',
  'form_order_payment_method_edit_field_price_without_vat' => 'Cena bez DPH',
  
  // edit order
  'form_order_edit_heading' => 'Editace objednávky',
  'form_order_edit_field_state' => 'Stav objednávky',
  'form_order_edit_field_payment_state' => 'Stav platby',
  'form_order_edit_field_package_number' => 'Číslo balíku',
  'form_order_edit_field_comments' => 'Poznámky',
  
  // edit order - customer
  'form_order_customer_edit_heading' => 'Editace objednatele',
  'form_order_customer_edit_group_group2' => 'Fakturační údaje',
  'form_order_customer_edit_group_group3' => 'Dodací údaje',
  'form_order_customer_edit_group_group1' => 'Kontaktní údaje',
  'form_order_customer_edit_field_login_name' => 'Přihlašovací jméno',
  'form_order_customer_edit_field_name' => 'Jméno',
  'form_order_customer_edit_field_surname' => 'Příjmení',
  'form_order_customer_edit_field_new_password' => 'Nové heslo',
  'form_order_customer_edit_field_email' => 'E-mail',
  'form_order_customer_edit_field_phone' => 'Telefon',
  'form_order_customer_edit_field_fax' => 'Fax',
  'form_order_customer_edit_field_street' => 'Ulice',
  'form_order_customer_edit_field_city' => 'Město',
  'form_order_customer_edit_field_postcode' => 'PSČ',
  'form_order_customer_edit_field_country' => 'Země',
  'form_order_customer_edit_field_company' => 'Firma',
  'form_order_customer_edit_field_ic' => 'IC',
  'form_order_customer_edit_field_dic' => 'DIC',
  'form_order_customer_edit_field_delivery_name' => 'Jméno',
  'form_order_customer_edit_field_delivery_surname' => 'Příjmení',
  'form_order_customer_edit_field_delivery_street' => 'Ulice',
  'form_order_customer_edit_field_delivery_city' => 'Město',
  'form_order_customer_edit_field_delivery_postcode' => 'PSČ',
  'form_order_customer_edit_field_delivery_country' => 'Země',
  'form_order_customer_edit_field_delivery_company' => 'Firma',
  'form_order_customer_edit_field_delivery_phone' => 'Telefon',
  
  // edit order item
  'form_order_item_edit_heading' => 'Editace položky objednávky',
  'form_order_item_edit_group_group3' => 'Vložení nového produktu',
  'form_order_item_edit_field_name' => 'Název',
  'form_order_item_edit_field_code' => 'Kód',
  'form_order_item_edit_field_price_with_vat' => 'Cena s DPH',
  'form_order_item_edit_field_price_without_vat' => 'Cena bez DPH',
  'form_order_item_edit_field_vat_rate' => 'Sazba DPH [%]',
  'form_order_item_edit_field_count' => 'Počet kusů',
  'form_order_item_edit_field_product_id' => 'Produkt',
  
  // edit order delivery
  'form_order_editdeliverymethod_heading' => 'Způsob dopravy',
  'form_order_editdeliverymethod_group_group2' => 'Změna způsobu dopravy',
  'form_order_editdeliverymethod_field_delivery_method_name' => 'Název',
  'form_order_editdeliverymethod_field_delivery_method_price' => 'Cena',
  'form_order_editdeliverymethod_field_order_delivery_method_id' => 'Nový způsob dopravy',
  
  // edit order payment
  'form_order_editpaymentmethod_heading' => 'Způsob platby',
  'form_order_editpaymentmethod_group_group2' => 'Změna způsobu platby',
  'form_order_editpaymentmethod_field_payment_method_name' => 'Název',
  'form_order_editpaymentmethod_field_payment_method_price' => 'Cena',
  'form_order_editpaymentmethod_field_order_payment_method_id' => 'Nový způsob platby',
  
  //-------- FILTERS ---------------- //
  'form_order_filter_field_state' => 'Stav objednávky',
  'form_order_filter_field_payment_state' => 'Stav platby',
  'form_order_filter_field_surname' => 'Příjmení',
  
  'form_product_filter_field_code' => 'Kód',
  'form_product_filter_field_name' => 'Název',
  'form_product_filter_field_product_category_id' => 'Kategorie',
  
  //-------- VALIDATIONS ------------ //
  
  'validate.product_code.exists_product_with_code' => 'Vámi zadaný kód produktu (:value) zadaný do pole `:field` nebyl nalezen.',
);
