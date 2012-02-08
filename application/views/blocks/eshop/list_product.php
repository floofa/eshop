<div class="item<?if($last):?> last<?endif;?>">
  <div class="title">
    <h2><a title="<?=$product->name?>" href="<?=$product->get_url()?>"><?=$product->name?></a></h2>
  </div>
  <div class="thumb">
    <?if ($img_src = $product->get_main_img_src('s')):?>
      <a title="<?=$product->name?>" href="<?=$product->get_url()?>"><img alt="<?=$product->name?>" src="<?=$img_src?>"></a>
    <?endif;?>
  </div>
  
  <div class="info">
    <div class="price">
      <span class="highlight"><?=number_format($product->price, '.', 0, ' ')?> Kč</span><br /> včetně DPH
    </div>
    
    <div class="line"></div>
    
    <div class="links">
      <?=text::limit_chars($product->short_description, '75', '...')?>
    </div>
  </div>
</div>