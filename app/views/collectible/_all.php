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

