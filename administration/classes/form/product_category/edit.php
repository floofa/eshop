<?php defined('SYSPATH') or die('No direct script access.');

class Form_Product_Category_Edit extends Forms_List
{
  public function build()
  {
    $this->group('group1');
    $this->col('col1')
      ->add('name')
      ->add('rew_id')
      ->add('cms_status', 'bool', TRUE);
      
    $this->col('col2')
      ->add('meta_description')
      ->add('meta_keywords');
      
    $this->col('col')
      ->add('description', 'textarea', array ('attr' => array ('rows' => 5)));
      
    $this->add_gallery('product_categories', $this->_model, $this->_model_id);
  }
  
  public function do_form($values = array (), $refresh = TRUE, $redirect = FALSE)
  {
    $orm_object = $this->_load_orm_object();
    
    if ( ! $orm_object->loaded()) {
      $mptt_object = ORM::factory('product_categorymptt');
      $parent = ($this->_data['parent_id']) ? $this->_data['parent_id'] : ORM::factory('product_categorymptt')->get_root(1);
      $mptt_object->values($values)->insert_as_last_child($parent);
      
      $orm_object = ORM::factory($this->_model, $mptt_object->id);
    }
    else {
      $orm_object->values($values)->save();
    }
    
    Request::redirect_initial(Route::get('mptt-list')->uri(array ('controller' => Request::initial()->controller(), 'id' => $orm_object->scope)));
  }
}
