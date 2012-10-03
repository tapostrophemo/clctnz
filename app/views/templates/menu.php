<h2>menu</h2>

<ul>
<?php foreach ($collectibles as $collectible): $name = preg_replace('/_/', ' ', $collectible) ?>
 <li>
  <a href="/collectible/add/<?=$collectible?>">Add</a> /
  <a href="/collectible/all/<?=$collectible?>">view all</a>
  <?=$collectible?>
 </li>
<?php endforeach; ?>
</ul>

