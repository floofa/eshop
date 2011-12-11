<h1>Košík</h1>

<?if ($count_items):?>
  <?=Forms::get('edit', 'basket')?>
  
  <?if ($free_delivery !== FALSE):?>
    <?if ($free_delivery === TRUE):?>
      <p>Máte dopravu <strong>zdarma</strong>.</p>
    <?else:?>
      <p>Přidejte zboží za dalších <strong><?=number_format($free_delivery, 0, '.', ' ')?>,- Kč</strong> a získáte dopravu <strong>ZDARMA</strong>.</p>
    <?endif;?>
  <?endif;?>
  
  <div>
    <a href="<?=URL::site()?>">Vybrat další produkty</a>
    <a href="<?=Route::url('purchase-delivery_and_payment')?>">Pokračovat</a>
  </div>
<?else:?>
  <p>Váš nákupní košík je prázdný.</p>
  
  <div>
    <a href="<?=URL::site()?>">Vybrat produkty</a>
  </div>
<?endif;?>

