<h2>menu</h2>

<ul>
<?php foreach ($collectibles as $collectible): $name = strtolower(humanize($collectible)) ?>
 <li>
  <a href="/collectible/add/<?=$collectible?>">Add</a> /
  <a href="/collectible/all/<?=$collectible?>">view all</a>
  <?=$name?>
 </li>
<?php endforeach; ?>
</ul>

