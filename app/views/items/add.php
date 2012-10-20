<?php $this->view("header"); ?>

<h2>add <?=$collectible?></h2>

<div class="help">
 <p>This page allows you to add a new collectible.</p>
</div>

<?=form_open("items/add/$collectible")?>

<?=validation_errors()?>

<?php foreach ($fields as $field): if ($field->name != 'id'): ?>
<p>
 <label><?=strtolower(humanize($field->name))?></label><br/>
<?php if ($field->type == 'text'): ?>
 <textarea name="<?=$field->name?>" rows="3" cols="35"></textarea>
<?php elseif ($field->type == 'tinyint' && $field->max_length == 1): ?>
 <input type="checkbox" name="<?=$field->name?>" value="1">
<?php else: ?>
 <input type="text" name="<?=$field->name?>" <?=$field->type == 'int' ? 'size="9"' : '';?>/>
 <?php
 if (array_key_exists($field->name, $refs)) {
   echo '<div class="ref"><label>' . $refs[$field->name] . '</label>';
   $rawData = $this->db->get($refs[$field->name])->result_array();
   $this->load->view('items/_all', array('hide_header_row' => true, 'data' => $rawData));
   echo '</div>';
 }
 ?>
<?php endif; ?>
</p>
<?php endif; endforeach; ?>

<input type="submit" value="save"/>

</form>

<?php $this->view("footer"); ?>

