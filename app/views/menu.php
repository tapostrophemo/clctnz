<?php $this->view("header"); ?>

<h2>menu</h2>

<ul>
 <li><a href="/collectible/define">Define collectible</a></li>
<?php foreach ($collectibles as $collectible): ?>
 <li><a href="/collectible/add/<?=$collectible?>">Add <?=preg_replace('/_/', ' ', $collectible)?></a></li>
<?php endforeach; ?>
 <li><a href="/collectible/edit">Edit (/view) collectible</a></li>
 <li><a href="/collectible/all">View all items in a collection</a></li>
</ul>

<?php $this->view("footer"); ?>

