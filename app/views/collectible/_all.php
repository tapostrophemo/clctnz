<table>

<?php if (!isset($hide_header_row) || (isset($hide_header_row) && !$hide_header_row)): ?>
 <tr>
 <?php foreach ($fields as $field): ?>
  <th><?=preg_replace('/_/', '&nbsp;', $field->name)?></th>
 <?php endforeach; ?>
 </tr>
<?php endif; ?>

<?php foreach ($data as $row): ?>
 <tr>
 <?php foreach ($row as $element): ?>
  <td><?=$element?></td>
 <?php endforeach; ?>
 </tr>
<?php endforeach; ?>

</table>

