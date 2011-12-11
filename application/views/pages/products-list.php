<h1><a href="<?=$category_link?>"><?=$category->name?></a></h1>

<?if (strlen($category->description)):?>
  <p><?=$category->description?></p>
<?endif;?>

<?if (count($products)):?>
  <div class="product-list">
    <?foreach ($products as $key => $product):?>
    <?//cms::i($product->id)?>
      <?=Request::factory(Route::get('products-block_list_product')->uri(array ('id' => $product->id, 'last' => (($key + 1) % 3 == 0))))->execute()?>
      <?//=Request::factory('products/product_in_list/' . $product->id)->post(array ('last' => (($key + 1) % 3 == 0)))->execute()?>
    <?endforeach;?>
  </div>
  
  <?if ($pagination->total_items > 9):?>
    <div class="howMuch">
      Počet produktů na stránku:

      <a href="<?=URL::site('', TRUE) . Request::initial()->query(array ('itemsPerPage' => '9', 'page' => NULL))->uri()?>" class="perPage9<?if($pagination->items_per_page == 9):?> active<?endif;?>">9</a>
      -
      <a href="<?=URL::site('', TRUE) . Request::initial()->query(array ('itemsPerPage' => '18', 'page' => NULL))->uri()?>" class="perPage18<?if($pagination->items_per_page == 18):?> active<?endif;?>">18</a>
      -
      <a href="<?=URL::site('', TRUE) . Request::initial()->query(array ('itemsPerPage' => '100', 'page' => NULL))->uri()?>" class="perPageAll<?if($pagination->items_per_page == 100):?> active<?endif;?>">vše</a>
    </div>
  <?endif;?>
  
  <?=$pagination?>
<?else:?>
  <p>Je nám líto, ale Vámi zvolená kategorie neobsahuje žádné zboží.</p>
<?endif;?>