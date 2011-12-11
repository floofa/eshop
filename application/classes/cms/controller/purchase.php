<?php defined('SYSPATH') or die('No direct script access.');

abstract class Cms_Controller_Purchase extends Controller_Builder_Template_Application
{
  protected $_show_navigation = FALSE;
  
  public function before()
  {
    parent::before();
    
    Navigation::$show = $this->_show_navigation;
  }
  
  /**
  * doprava a platba
  */
  public function action_delivery_and_payment()
  {
    $this->_check_step_allowed('delivery_and_payment');
  }
  
  /**
  * osobni udaje
  */
  public function action_personal_data()
  {
    $this->_check_step_allowed('personal_data');
    
    $this->_view->personal_data_form = Forms::get('personal_data', 'purchase');
  }
  
  /**
  * shrnuti objednavky
  */
  public function action_summary()
  {
    $this->_check_step_allowed('summary');
    
    $basket = Basket::instance();
    $purchase = Session::instance()->get('purchase');
    $free_delivery = eshop::has_free_delivery() === TRUE;
    
    $delivery_method = ORM::factory('order_delivery_method', $purchase['order_delivery_method_id']);
    $payment_method = ORM::factory('order_payment_method', $purchase['order_payment_method_id']);
    
    $items_price = $basket->get_items_price();
    $total_price = $items_price + (($free_delivery) ? 0 : $delivery_method->price_with_vat) + $payment_method->price_with_vat;
    
    $this->_view->items = $basket->get_items();
    $this->_view->total_price = $total_price;
    
    $this->_view->delivery_method = $delivery_method;
    $this->_view->payment_method = $payment_method;
    $this->_view->free_delivery = $free_delivery;
    
    $this->_view->set($purchase['personal_data']);
  }
  
  /**
  * dokonceni objednavky - objednani zbozi
  */
  public function action_buy()
  {
    $this->_check_step_allowed('buy');
    
    $basket = Basket::instance();
    $purchase = Session::instance()->get('purchase');
    $personal_data = $purchase['personal_data'];
    
    Database::instance()->begin();
    
    try {
      $order = ORM::factory('order');
      
      $free_delivery = eshop::has_free_delivery() === TRUE;
      
      // nastaveni zpusobu dopravy a platby
      $order->set_delivery_method($purchase['order_delivery_method_id'], $free_delivery)
            ->set_payment_method($purchase['order_payment_method_id']);

      // fakturacni udaje
      $order_values = arr::extract($personal_data, array (
        'name', 'surname', 'street', 'city', 'postcode',
        'phone', 'email',
      ));
      
      // firemni udaje
      if (isset($personal_data['company_data'])) {
        $order_values += arr::extract($personal_data, array ('company', 'cin', 'tin'));
      }
      
      // dorucovaci udaje
      if (isset($personal_data['delivery_address'])) {
        $order_values += arr::extract($personal_data, array (
          'delivery_company', 'delivery_name', 'delivery_surname', 
          'delivery_street', 'delivery_city', 'delivery_postcode',
          'delivery_phone',
        ));
      }
      
      // ulozeni objednavky
      $order->values($order_values)->save();
      
      // pridani polozek do objednavky
      foreach ($basket->get_items() as $item) {
        if ($item['count'] <= 0)
          continue;
        
        $product = ORM::factory('product', $item['id']);
        
        if ( ! $product->loaded())
          continue;
          
        // ulozeni polozky
        $order_item = ORM::factory('order_item');
        $order_item->order_id = $order->id;
        $order_item->set_product($product);
        $order_item->count = $item['count'];
        $order_item->save();
        
        if (Kohana::$config->load('cms.eshop.auto_manipulation_with_stock')) {
          $product->count_stock -= $order_item->count;
          $product->save();
        }
      }
      
      Database::instance()->commit();
      
    } catch (Exception $e) {
      Database::instance()->rollback();
      throw $e;
    }
    
    // odeslani emailu se shrnutim objednavky
    Email::factory('Objednávka na archibox.cz', 
      View::factory('_emails/order')
        ->set('order', $order)
        ->set('order_items', $order->order_items->find_all())
        ->set('users_enabled', Kohana::config('cms.eshop.users'))
        ->render(), 'text/html'
      )
      ->from('obchod@archibox.cz')
      ->to($order->email)
      ->bcc('obchod@archibox.cz')
      ->send();
    
    // odstrani polozky z kosiku
    $basket->clear();
    
    // odstrani nakupni proces
    Session::instance()->delete('purchase');
    
    // presmerovani na shrnuti objednavky
    Request::$current->redirect(Route::get('purchase-done')->uri(array ('order_id' => $order->id, 'hash' => $order->hash)));
  }
  
  public function action_done()
  {
    $order = ORM::factory('order', $this->request->param('order_id'));
    
    if ( ! $order->loaded() || ! strlen($this->request->param('hash')) || $this->request->param('hash') != $order->hash)
      throw new HTTP_Exception_404('The requested URL :uri was not found on this server.', array (':uri' => $this->request->uri()));
      
    $this->_view->order = $order;
  }
  
  /**
  * overi, jestli jsou dostupna vsechna data pro dany krok
  * 
  * @param mixed $step
  */
  public function _check_step_allowed($step)
  {
    // overeni, jestli je v kosiku nejake zbozi
    if ( ! Basket::instance()->get_count_species())
      $this->request->redirect(Route::get('basket')->uri());
      
    if ($step == 'delivery_and_payment')
      return TRUE;
      
    $purchase = Session::instance()->get('purchase');
    
    // overeni, jestli byl zadan zpusob dopravy a platby
    if ( ! $purchase || ! isset($purchase['order_delivery_method_id']) || ! isset($purchase['order_payment_method_id']))
      $this->request->redirect(Route::get('purchase-delivery_and_payment')->uri());
    
    if ($step == 'personal_data')
      return TRUE;
    
    // overeni, jestli je zadano vse (pro shrnuti a dokonceni nakupu)
    if ( ! isset($purchase['personal_data']))
      $this->request->redirect(Route::get('purchase-personal_data')->uri());
      
    return TRUE;
  }
  
  
}
