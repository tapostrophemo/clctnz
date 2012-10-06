<?php $this->view("header"); ?>

<h2>view all <?=$collectible?></h2>

<div class="help">
 <p>This page allows you to view all collectibles in a "collection", i.e., of a certain type.</p>
</div>

<?php $this->load->view('items/_all', array('fields' => $fields, 'data' => $data)); ?>

<p><a href="/items/add/<?=$collectible?>">Add <?=$collectible?></a></p>

<?php $this->view("footer"); ?>

