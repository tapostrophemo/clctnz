<?php $this->view("header"); ?>

<h2>menu</h2>

<ul>
 <li><a href="/collectible/define">Define collectible</a></li>
<?php foreach ($collectibles as $collectible): $name = preg_replace('/_/', ' ', $collectible) ?>
 <li><a href="/collectible/add/<?=$collectible?>">Add <?=$name?></a></li>
 <li><a href="/collectible/all/<?=$collectible?>">View all <?=$name?></a></li>
<?php endforeach; ?>
 <li><a href="/collectible/edit">Edit (/view) collectible</a></li>
</ul>

<?php $this->view("footer"); ?>

