<div id="category-menu">
  <?foreach ($menu->get_items() as $item_lvl1):?>
    <h2><?=$item_lvl1['label']?></h2>
    
    <?if ($items_lvl2 = $item_lvl1['subitems']):?>
      <ul>
        <?foreach ($items_lvl2 as $item_lvl2):?>
          <li><a class="lvl2<?if($item_lvl2['active']):?> active<?endif;?>" href="<?=$item_lvl2['link']?>"><?=$item_lvl2['label']?></a></li>
        <?endforeach;?>
      </ul>
    <?endif;?>
  <?endforeach;?>
<!--
    <h2>Sushi</h2>
  <ul>
    <li><a href="list.html">Omáčky</a></li>
    <li><a href="list.html">Nudle</a></li>
    <li class="active"><a href="list.html">Rýže</a></li>
    <li><a href="list.html">Zelenina</a></li>
  </ul>
  
  <h2>Nápoje</h2>
  <ul>
    <li><a href="list.html">Juices</a></li>
    <li><a href="list.html">Nudle</a></li>
    <li><a href="list.html">Rýže</a></li>
    <li><a href="list.html">Zelenina</a></li>
  </ul-->
</div>