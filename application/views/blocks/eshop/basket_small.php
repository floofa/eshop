<?if ($count):?>
  <div id="basket-small">
    <a href="<?=Route::url('basket', array (), TRUE)?>">
      <img src="<?=URL::site('media/images/basket.png')?>" class="fl" />
      <span class="text"><?=___('<span>:count ks</span> zboží celkem za <span>:price Kč</span>', $count, array (':count' => $count, ':price' => number_format($price, 0, '.', ' ')))?></span>
    </a>
  </div>
<?else:?>
  <div id="basket-small">
    <img src="<?=URL::site('media/images/basket.png')?>" class="fl" />
    <span class="text">nákupní košík je prázdný.</span>
  </div>
<?endif;?>