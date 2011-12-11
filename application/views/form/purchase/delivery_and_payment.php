<?=$form->open()?>
  <?if ($errors = $form->errors()):?>
    <?foreach ($errors as $error):?>
      <?=$error?><br />
    <?endforeach;?>
  <?endif;?>
  
  <h2>Vyberte způsob dopravy</h2>
  
  <div class="list-of-options">
    <?foreach ($data['delivery_methods'] as $method):?>
      <div class="item<?if($form->order_delivery_method_id->val() == $method->id):?> active<?endif;?>">
        <input type="radio" class="delivery-method" id="delivery_method_<?=$method->id?>" value="<?=$method->id?>" name="<?=$form->order_delivery_method_id->name()?>"<?if($form->order_delivery_method_id->val() == $method->id):?> checked="checked"<?endif;?>> 
        <label for="delivery_method_<?=$method->id?>"><?=$method->name?> (<?=($data['free_delivery'] || $method->price_with_vat <= 0) ? 'ZDARMA' : number_format($method->price_with_vat, 0, '.', ' ') . ',- Kč'?>)</label> 
        <p><?=$method->description?></p>
      </div>
    <?endforeach;?>
  </div>
  
  <h2>Vyberte způsob platby</h2>
  
  <div class="list-of-options">
    <?foreach ($data['payment_methods'] as $method):?>
      <div class="item<?if($form->order_payment_method_id->val() == $method->id):?> active<?endif;?>">
        <input type="radio" class="payment-method" id="payment_method_<?=$method->id?>" value="<?=$method->id?>" name="<?=$form->order_payment_method_id->name()?>"<?if($form->order_payment_method_id->val() == $method->id):?> checked="checked"<?endif;?>> 
        <label for="payment_method_<?=$method->id?>"><?=$method->name?> (<?=($method->price_with_vat > 0) ? number_format($method->price_with_vat, 0, '.', ' ') . ',- Kč' : 'ZDARMA'?>)</label> 
        <p><?=$method->description?></p>
      </div>
    <?endforeach;?>
  </div>
  
  <a href="<?=Route::url('basket')?>">zpět do košíku</a>
  
  <input type="submit" value="Pokračovat" />
</form>