<?php $this->view("header"); ?>

<h2>view all <?=$collectible?></h2>

<div class="help">
 <p>This page allows you to view all collectibles in a "collection", i.e., of a certain type.</p>
</div>

<table>

 <tr>
 <?php foreach ($fields as $field): ?>
  <th><?=preg_replace('/_/', '&nbsp;', $field->name)?></th>
 <?php endforeach; ?>
 </tr>

<?php foreach ($data as $row): ?>
 <tr>
 <?php foreach ($row as $element): ?>
  <td><?=$element?></td>
 <?php endforeach; ?>
 </tr>
<?php endforeach; ?>

</table>

<p><a href="/collectible/add/<?=$collectible?>">Add <?=$collectible?></a></p>

<?php $this->view("footer"); ?>

