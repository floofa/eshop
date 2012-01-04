<div class="content-box ">
  <div class="content-box-header">
    <h3>Objednávka č. <?=$order->number?></h3>
  </div> <!-- End .content-box-header -->
        
  <div class="content-box-content highlight-box">
    <div class="tab-content default-tab">
      <div class="cols cols4">
        <div class="col1">
          <h5>Obecné údaje</h5>
          Cena: <b><?=number_format($order->total_price, 0, '.', ' ')?>,- Kč</b> (s DPH)<br />
          Stav objednávky: <b><?=mb_strtolower(___('orders_states.' . $order->state))?></b>, <b<?if( ! $order->payment_state):?> style="color:red"<?else:?> style="color:green"<?endif;?>><?=mb_strtolower(___('orders_payment_states.' . $order->payment_state))?></b><br />
          Datum: <?=date('d.m.Y - H:i', $order->timestamp)?><br />
          Číslo: <?=$order->number?><br />
          VS: <?=$order->vs?>
        </div>
        <div class="col2">
          <h5>Fakturační údaje</h5>
          <?if (strlen($order->company)):?>
            <?=$order->company?><br />
          <?endif;?>
          <?=$order->name?> <?=$order->surname?><br />
          <?=$order->street?><br />
          <?=$order->postcode?> <?=$order->city?><br />
          <?=$order->country?><br />
          <?if (strlen($order->ic)):?>
            IČ: <?=$order->ic?><br />
          <?endif;?>
          <?if (strlen($order->dic)):?>
            DIČ: <?=$order->dic?><br />
          <?endif;?>
        </div>
        
        <div class="col3">
          <h5>Doručovací údaje</h5>
          <?if (strlen($order->delivery_company)):?>
            <?=$order->delivery_company?><br />
          <?endif;?>
          <?=$order->delivery_name?> <?=$order->delivery_surname?><br />
          <?=$order->delivery_street?><br />
          <?=$order->delivery_postcode?> <?=$order->delivery_city?><br />
          <?=$order->delivery_country?><br />
        </div>
        
        <div class="col4">
          <h5>Ostatní</h5>
          <?=$order->email?><br />
          <?=$order->phone?>
          <?if (strlen($order->delivery_phone) && $order->phone != $order->delivery_phone):?>
            (fakturační)<br />
            <?=$order->delivery_phone?> (doručovací)<br />
          <?endif;?>
        </div>
      </div>
      
      <hr class="clear" />
      
      <div class="buttons">
        <a href="<?=Route::url('orders_invoice', array ('id' => $order->id), TRUE)?>" target="_blank">Vytisknout objednávku</a>
      </div>
      
      <div class="clear"></div>
      
    </div> <!-- End #tab3 -->        
  </div> <!-- End .content-box-content -->
</div>

<div class="content-box">
  <div class="content-box-header">
    <h3>Shrnutí objednávky</h3>

    <div class="buttons">
      <a class="new-button" href="<?=Route::url('orders_items', array ('action' => 'edit_item', 'id' => $order->id, 'item_id' => 0))?>">Přidat položku</a>          
    </div>
    <div class="clear"></div>
  </div>    
  
  <div class="content-box-content">
    <table id="datalist-order_items" class="datalist-browse">
      <thead>
        <tr>
          <th class="th-name">Název</th>
          <th class="th-code">Kód</th>
          <th class="th-price fr">Cena za ks</th>
          <th class="th-count">Počet</th>
          <th class="th-total_price fr">Cena celkem</th>
          <th class="th-actions">Akce</th>
        </tr>
      </thead>
        
      <tbody>
        <?foreach ($order_items as $item):?>
          <tr class="order-item-row">  
            <td class="td-name redirect"><?=$item->name?></td>
            <td class="td-code redirect"><?=$item->code?></td>
            <td class="td-price fr redirect"><?=number_format($item->price_with_vat, 2, '.', ' ')?>,- Kč</td>
            <td class="td-count redirect"><?=$item->count?>x</td>
            <td class="td-total_price fr redirect"><?=number_format($item->total_price, 2, '.', ' ')?>,- Kč</td>
            <td class="td-actions">
              <a class="action-edit" href="<?=Route::url('orders_items', array ('action' => 'edit_item', 'id' => $order->id, 'item_id' => $item->id))?>"><img src="<?=Linker::file('media', 'admin', 'images', 'icons', 'pencil.png')?>"></a>
              <a class="action-delete" href="<?=Route::url('orders_items', array ('action' => 'delete_item', 'id' => $order->id, 'item_id' => $item->id))?>"><img src="<?=Linker::file('media', 'admin', 'images', 'icons', 'cross.png')?>"></a>
            </td>
          </tr>
        <?endforeach;?>
        
        <tr class="service-row">
          <td colspan="3" class="redirect">Doprava - <?=$order->delivery_method_name?></td>
          <td colspan="" class="redirect">1x</td>
          <td class="fr redirect"><?=number_format($order->delivery_method_price, 2, '.', ' ')?> Kč</td>
          <td class="td-actions">
            <a class="action-edit" href="<?=Route::url('default', array ('controller' => Request::initial()->controller(), 'action' => 'edit_delivery_method', 'id' => $order->id))?>"><img src="<?=Linker::file('media', 'admin', 'images', 'icons', 'pencil.png')?>"></a>
          </td>
        </tr>
        <tr class="service-row">
          <td colspan="3" class="redirect">Platba - <?=$order->payment_method_name?></td>
          <td colspan="" class="redirect">1x</td>
          <td class="fr redirect"><?=number_format($order->payment_method_price, 2, '.', ' ')?> Kč</td>
          <td class="td-actions">
            <a class="action-edit" href="<?=Route::url('default', array ('controller' => Request::initial()->controller(), 'action' => 'edit_payment_method', 'id' => $order->id))?>"><img src="<?=Linker::file('media', 'admin', 'images', 'icons', 'pencil.png')?>"></a>
          </td>
        </tr>
        
        
        <tr class="final-price">
          <td colspan="4">Celková cena s DPH</td>
          <td class="fr" colspan="1"><?=number_format($order->total_price_rounded, 2, '.', ' ')?> Kč </td>
          <td><span>(<?=number_format($order->total_price, 2, '.', ' ')?> Kč)</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?=$form?>

<script type="text/javascript">
<!--
  $(function(){
    // items rows redirect
    $("tr.order-item-row td.td-actions a.action-edit").each(function() {
      var href = $(this).attr("href");
      
      $(this).parent().parent().find('td.redirect').each(function() {
        $(this).click(function() {
          $.cms.redirect(href);
        });
      });
    });
    
    // service rows redirect
    $("tr.service-row td.td-actions a.action-edit").each(function() {
      var href = $(this).attr("href");
      
      $(this).parent().parent().find('td.redirect').each(function() {
        $(this).click(function() {
          $.cms.redirect(href);
        });
      });
    });
    
    $("a.action-delete").click(function(){
      if (confirm("Opravdu chcete smazat tuto položku?")) {
        $.cms.redirect($(this).attr("href"));
      }
    });
  });
//-->
</script>