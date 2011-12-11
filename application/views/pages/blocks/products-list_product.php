<div class="product<?if($last):?> last<?endif;?>">
  <h2><a title="<?=$product->name?>" href="<?=$product->get_url()?>"><?=$product->name?></a></h2>
  <div class="thumb">
    <?if ($img_src = $product->get_main_img_src('s')):?>
      <a title="<?=$product->name?>" href="<?=$product->get_url()?>"><img alt="<?=$product->name?>" src="<?=$img_src?>"></a>
    <?endif;?>
  </div>
  
  <span class="price"><?=number_format($product->price, '.', 0, ' ')?>,- Kč</span>
  <p class="spec"><?=text::limit_chars($product->description, '60', '...')?></p>
</div>