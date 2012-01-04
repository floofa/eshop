<?if ($count):?>
  <div id="basket_area">
    <div class="qty">
      <?=___('<span>:count ks</span> celkem za <span>:price Kč</span>', $count, array (':count' => $count, ':price' => number_format($price, 0, '.', ' ')))?>
    </div>
          
    <a class="checkout" href="<?=Route::url('basket')?>">
      &gt;&gt; <?=___('PŘEJÍT K POKLADNĚ')?>&lt;&lt;
    </a>
  </div>
<?endif;?>