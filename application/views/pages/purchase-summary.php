<h1>Shrnutí objednávky</h1>

<div>
  <table class="tab tabCart">
    <thead>
      <tr class="top">
        <th>Název</th>
        <th class="count">Množství</th>
        <th>Cena</th>
      </tr>
    </thead>
    <tbody>
      <?foreach ($items as $key => $item):?>
        <tr>
          <td><?=$item['name']?></td>
          <td><?=$item['count']?></td>
          <td><?=number_format($item['count'] * $item['price'], 0, '.', ' ')?>,- Kč</td>
        </tr>
      <?endforeach;?>
      
      <tr>
        <td>Doprava - <?=$delivery_method->name?></td>
        <td>1</td>
        <td><?if ($free_delivery):?>0<?else:?><?=number_format($delivery_method->price_with_vat, 0, '.', ' ')?><?endif;?>,- Kč</td>
      </tr>
      <tr>
        <td>Platba - <?=$payment_method->name?></td>
        <td>1</td>
        <td><?=number_format($payment_method->price_with_vat, 0, '.', ' ')?>,- Kč</td>
      </tr>
      <tr>
        <td colspan="2">Cena celkem</td>
        <td><?=number_format($total_price, 0, '.', ' ')?>,- Kč</td>
      </tr>
    </tbody>
  </table>
</div>

<div>
  <h2>Fakturační údaje</h2>
  <div>
    <?if ($company_data):?>Firma: <?=$company?><br /><?endif;?>
    Jméno: <?=$name?><br />
    Příjmení: <?=$surname?><br />
    Ulice: <?=$street?><br />
    Město: <?=$city?><br />
    PSČ: <?=$postcode?><br /><br />
    
    <?if ($company_data):?>
      IČ: <?=$cin?><br />
      DIČ: <?=$tin?><br /><br />
    <?endif;?>
    
    E-mail: <?=$email?><br />
    Telefon: <?=$phone?>
  </div>
</div>

<div>
  <h2>Doručovací adresa</h2>

  <div>
    <?if ($delivery_address):?>
      <?if (strlen($delivery_company)):?>Firma: <?=$delivery_company?><br /><?endif;?>
      Jméno: <?=$delivery_name?><br />
      Příjmení: <?=$delivery_surname?><br />
      Ulice: <?=$delivery_street?><br />
      Město: <?=$delivery_city?><br />
      PSČ: <?=$delivery_postcode?><br />
      
      <?if (strlen($delivery_phone)):?>
        <br />
        Telefon: <?=$delivery_phone?>
      <?endif;?>
    <?else:?>
      <?if ($company_data):?>Firma: <?=$company?><br /><?endif;?>
      Jméno: <?=$name?><br />
      Příjmení: <?=$surname?><br />
      Ulice: <?=$street?><br />
      Město: <?=$city?><br />
      PSČ: <?=$postcode?><br /><br />
    <?endif;?>
  </div>
</div>

<a href="<?=Route::url('purchase-personal_data')?>">Zpět na osobní údaje</a>
<a href="<?=Route::url('purchase-buy')?>">Objednat</a>
