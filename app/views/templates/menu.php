<h2>menu</h2>

<ul>
<?php foreach ($collectibles as $collectible): $name = preg_replace('/_/', ' ', $collectible) ?>
 <li><a href="/<?=$collectible?>/add">Add <?=$name?></a></li>
 <li><a href="/<?=$collectible?>/all">View all <?=$name?></a></li>
<?php endforeach; ?>
</ul>

