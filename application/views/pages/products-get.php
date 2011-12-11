<h1><a href="<?=$product->get_url()?>"><?=$product->name?></a></h1>

<div class="descriptions">
    <?if (strlen(strip_tags($product->description))):?>
      <h4>Popis produktu:</h4>
      <p><?=$product->description?></p>
    <?endif;?>
    
    <ul class="info">
      <li><strong>Kód produktu:</strong> <span><?=$product->code?></span></li>
      <li><strong>Kategorie:</strong> <a title="<?=$product->product_category->name?>" href="<?=$product->product_category->get_url()?>"><?=$product->product_category->name?></a></li>
      <li><strong>Dostupnost:</strong> <?if ($product->count_stock > 0):?><span class="store">Skladem</span><?else:?><span class="store">Není skladem</span><?endif;?></li>
      <?/*<li><strong>Doba dodání:</strong> <?=$product->text_delivery_time?></li>*/?>
      
      <?if (Kohana::$config->load('cms.eshop.display_price_with_vat')):?>
        <li class="price"><strong>Cena:</strong> <span><?=number_format($product->price_final_with_vat, 0, '.', ' ')?> Kč</span> včetně DPH<br />  <?=number_format($product->price_final_without_vat, 2, '.', ' ')?> Kč bez DPH</li>
      <?else:?>
        <li class="price"><strong>Cena:</strong> <span><?=number_format($product->price_final_without_vat, 2, '.', ' ')?> Kč</span> bez DPH<br />  <?=number_format($product->price_final_with_vat, 0, '.', ' ')?> Kč včetně DPH</li>
      <?endif;?>
      
    </ul>

    <div class="action-box">
      <?=Forms::get('add', 'basket', FALSE, FALSE, array ('product' => $product))?>
    </div>
  </div>
  
  <div class="image-product">
    <ul class="image-big">
      <?if (count($product_images)):?>
        <?foreach ($product_images as $key => $image):?>
          <li<?if ($key == 0):?> class="active"<?endif;?>>
            <a href="<?=$image->get_src()?>" class="fancybox" title="<?=$product->name?> (<?=$key + 1?>)" rel="img-product">
              <img alt="<?=$product->name?>" src="<?=$image->get_src('m')?>" />
            </a>
          </li>
        <?endforeach;?>
      <?endif;?>
    </ul>
    
    <div class="thumbs">
      <ul class="slider">
        <?if (count($product_images)):?>
          <?foreach ($product_images as $key => $image):?>
            <li>
              <a href="javascript:void(0);" title="<?=$product->name?>"><img width="72" alt="<?=$product->name?>" src="<?=$image->get_src('s')?>" /></a>
            </li>
          <?endforeach;?>
        <?endif;?>
      </ul>
    </div>
  </div>