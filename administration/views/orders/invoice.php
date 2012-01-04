<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
  <html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
    <title>Objednávka</title>
    <style media="all" type="text/css">

      body{padding:0; margin:0; font-family:"Verdana CE", Verdana, "Arial CE", "Lucida Grande CE", "Helvetica CE", Arial, lucida, sans-serif; font-size:8pt; color:#000;}  
      
      .cele{position:relative; height:94%; padding:1%; margin:1%; border:1pt solid #000;}
      
      h1{
        font-size: 14pt;
        font-weight: bold;
        text-align: right;
        padding: 2pt 20pt;
        margin: 10pt 0;
        border-bottom: 1pt solid gray;
      }
    
      .leve, .prave{width:50%; float:left;}
    
      .leve .tab,.leve .tab1,.prave .tab,.prave .tab1{
        border:1pt solid #A9A8A8;
        padding:4pt;
        margin-right:2pt;
      }
      
      .prave .tab,.prave .tab1{margin:0 0 0 2pt;}
      .leve .tab, .prave .tab{height:102pt;}
      .leve .tab1, .prave .tab1{margin-top:5pt; height:45pt;}
    
      table,th,td{border:1pt solid #A9A8A8;}
      
      table{
        font-size:8pt;
        border-collapse: collapse;
        width: 100%;
        margin-top: 5pt;
        clear:both;
      }
    
      th{font-weight:bold; text-align:center;}
      td{padding:0 2pt;}
    
      .spodek{position:absolute; left:0; bottom:10pt; padding:10pt; width:inherit;}
      .spodek .leve,.spodek .prave{float:left; margin-bottom:30pt;}
      .spodek .leve{width: 35%;}
      .spodek .prave{width: 65%;}
  
      .konec{
        clear:both;
        text-align: center;
        border-top: 1px solid gray;
        border-bottom: 1px solid gray;
      }
    </style>
  </head>
  <body onLoad="_print()">

  <div class="cele">
    <h1>OBJEDNÁVKA č. <?=$order->id?></h1>
    
    <div class="leve">
      <strong>Fakturační adresa</strong>
    </div>
    
    <div class="prave">
      <strong>Dodací adresa</strong>
    </div>
    
    <div class="leve">
      <div class="tab">
        <?if (strlen($order->company)):?>
          <strong><?=$order->company?></strong> <br />
          <?if (($order->name . ' ' . $order->surname) != $order->company):?>
            <?=$order->name?> <?=$order->surname?> <br />
          <?endif;?>
        <?else:?>
          <strong><?=$order->name?> <?=$order->surname?></strong> <br />
        <?endif;?>

        <?=$order->street?><br/>
        <?=$order->postcode?> <?=$order->city?><br/>
        Česká republika<br/><br/>
        IČO: <?=$order->ic?><br />
        DIČ: <?=$order->dic?><br /><br />
        
        <?=$order->email?><br />
        Telefon: <?=$order->phone?> <br />
      </div>
    </div>
    
    <div class="prave">
      <div class="tab">
        <?if (strlen($order->delivery_company)):?>
          <strong><?=$order->delivery_company?></strong> <br />
          <?if (($order->delivery_name . ' ' . $order->delivery_surname) != $order->delivery_company):?>
            <?=$order->delivery_name?> <?=$order->delivery_surname?> <br />
          <?endif;?>
        <?else:?>
          <strong><?=$order->delivery_name?> <?=$order->delivery_surname?></strong> <br />
        <?endif;?>
        <?=$order->delivery_street?><br/>
        <?=$order->delivery_city?><br/>
        <?=$order->delivery_postcode?><br /><br />
        
        Telefon: <?=$order->delivery_phone?>
      </div>
    </div>
    
    <div class="leve">
      <div class="tab1">
      <strong>Variabilní symbol: <?=$order->id?></strong><br>
      Způsob dopravy: <?=$order->delivery_method_name?><br>
      Způsob platby: <?=$order->payment_method_name?><br>
      </div>
    </div>
    <div class="prave">
      <div class="tab1">
      <strong>Datum objednávky:</strong> <?=date('d.m.Y', $order->timestamp)?></div>
    </div>

    <div class="clear"></div><br> 
    <table>
      <tr>
        <th style="width: 4%">č.</th>
        <th style="width: 36%">Popis</th>
        <th style="width: 10%">Cena/ks</th>
        <th style="width: 10%">Počet kusů</th>

        <th style="width: 10%">Cena</th>
        <th style="width: 10%">Sazba DPH</th>
        <th style="width: 10%">DPH</th>
        <th style="width: 10%">Cena vč. DPH</th>
      </tr>
      
      <?$key = 0;?>
      <?foreach ($order->order_items->find_all() as $key => $item):?>
        <tr>
          <td style="text-align: center;"><?=$key + 1?></td>
          <td><?=$item->name?></td>
          <td style="text-align: right;"><?=number_format($item->price_without_vat, 2, '.', ' ')?> Kč</td>
          <td style="text-align: center;"><?=$item->count?></td>
          <td style="text-align: right;"><?=number_format($item->price_without_vat * $item->count, 2, '.', ' ')?> Kč</td>
          <td style="text-align: center;"><?=$item->vat_rate?> %</td>
          <td style="text-align: right;"><?=number_format($item->total_price - $item->total_price_without_vat, 2, '.', ' ')?> Kč</td>
          <td style="text-align: right;"><?=number_format($item->total_price, 2, '.', ' ')?> Kč</td>
        </tr>
      <?endforeach;?>
      <tr>
        <td style="text-align: center;"><?=$key + 2?></td>
        <td>Doprava</td>
        <td style="text-align: right;"></td>
        <td style="text-align: center;"</td>
        <td style="text-align: right;"></td>
        <td style="text-align: center;"><?=number_format($order->delivery_method_vat, 0)?> %</td>
        <td style="text-align: right;"></td>
        <td style="text-align: right;"><?=number_format($order->delivery_method_price, 2, '.', ' ')?> Kč</td>
      </tr>
      <tr>
        <td style="text-align: center;"><?=$key + 3?></td>
        <td>Platba</td>
        <td style="text-align: right;"></td>
        <td style="text-align: center;"</td>
        <td style="text-align: right;"></td>
        <td style="text-align: center;"><?=number_format($order->payment_method_vat, 0)?> %</td>
        <td style="text-align: right;"></td>
        <td style="text-align: right;"><?=number_format($order->payment_method_price, 2, '.', ' ')?> Kč</td>
      </tr>
      
      <tr>
        <td colspan="8"></td>
      </tr>
      
      <tr>
        <td></td>
        <td><b>Celkem k úhradě</b></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td style="text-align: right;"><b><?=number_format($order->total_price_rounded, 2, '.', ' ')?> Kč</b></td>
      </tr>
    </table>

      <br />
      <strong>Poznámka</strong><br /> 
      <?=nl2br($order->comments)?>
      
      
      <?/* 
      <br />
          <div class="spodek">
    <div class="pomocne">
      <div class="leve">
      <!--
        <br />
        Vystavil/a: <br />
        Telefon: +420566616676<br />
        E-mail: info@obalyvysocina.cz<br />-->

      </div><div class="prave">
        <table>
          <tr>
            <td><strong>Celkem k úhradě</strong></td>
            <td align="right"><strong><?=number_format($order->total_price_rounded, 0, '.', ' ')?> Kč</strong> (<?=number_format($order->total_price, 2, '.', ' ')?>) Kč</td>

          </tr>
        </table>

      </div>
      <div class="clear"></div>
    </div>
    </div>
    */?>
    
  </div>

  </body>
  </html>
