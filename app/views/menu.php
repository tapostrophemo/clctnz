<?php $this->view("header"); ?>

<h2>menu</h2>

<h3>collections</h3>
<ul>
 <li><a href="/collectible/define">Define collectible</a></li>
<?php foreach ($collectibles as $collectible): $name = preg_replace('/_/', ' ', $collectible) ?>
 <li><a href="/collectible/alter/<?=$collectible?>">Alter '<?=$name?>' table</a></li>
<?php endforeach; ?>
</ul>

<h3>items</h3>
<ul>
<?php foreach ($collectibles as $collectible): $name = preg_replace('/_/', ' ', $collectible) ?>
 <li>
  <a href="/collectible/add/<?=$collectible?>">Add</a> /
  <a href="/collectible/all/<?=$collectible?>">view all</a>
  <?=$collectible?>
 </li>
<?php endforeach; ?>
 <li><a href="/collectible/items">View all collectibles</a></li>
</ul>

<h3>applications</h3>
<ul>
 <li><a href="/application/export">Export</a></li>
</ul>

<?php $this->view("footer"); ?>

