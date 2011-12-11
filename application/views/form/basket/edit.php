<?=$form->open()?>
  <table class="tab tabCart">
    <tbody>
      <tr class="top">
        <th>Název</th>
        <th class="count">Množství</th>
        <th>Cena</th>
        <th class="r"></th>
      </tr>
    
      <?foreach ($data['items'] as $key => $item):?>
        <tr>
          <td><a href="<?=Route::url('products-detail', array ('rew_id' => $item['rew_id']))?>"><?=text::limit_chars($item['name'], 30, '...')?></a></td>
          <td class="count"><?=$form->{'item_' . $key}->render()?></td>
          <td class="price"><?=number_format($item['count'] * $item['price'], 0, '.', ' ')?>,- Kč</td>
          <td><a class="ico ico-delete" href="<?=Route::url('basket-remove_item', array ('key' => $key))?>" title="odebrat z košíku">odebrat z košíku</a></td>
        </tr>
      <?endforeach;?>
      
      <tr class="total">
        <td>Celková cena</td>
        <td class="count"><button class="convert" type="submit"><span>Přepočítat</span></button></td>
        <td class="price price-final"><?=number_format($data['items_price'], 0, '.', ' ')?>,- Kč</td>
        <td></td>
      </tr>
    </tbody>
  </table>
</form>