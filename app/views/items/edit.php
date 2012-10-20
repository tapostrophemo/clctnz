<?php $this->view("header"); ?>

<h2>edit <?=$collectible?></h2>

<div class="help">
 <p>This page allows you to edit (or delete) an existing collectible.</p>
</div>


<?=form_open("items/delete/$collectible/{$item->id}")?>
 <p><a href="#" onclick="this.parentNode.parentNode.submit()">delete?</a></p>
</form>

<?=form_open("items/edit/$collectible/{$item->id}")?>
<input type="hidden" name="id" value="<?=$item->id?>"/>

<?=validation_errors()?>

<?php foreach ($fields as $field): if ($field->name != 'id'): ?>
<p>
 <label><?=strtolower(humanize($field->name))?></label><br/>
<?php if ($field->type == 'text'): ?>
 <textarea name="<?=$field->name?>" rows="3" cols="35"><?=form_prep($item->{$field->name})?></textarea>
<?php elseif ($field->type == 'tinyint' && $field->max_length == 1): ?>
 <input type="checkbox" name="<?=$field->name?>" value="1"<?=$item->{$field->name} == 1 ? " checked" : ""?>>
<?php else: ?>
 <input type="text" name="<?=$field->name?>" <?=$field->type == 'int' ? 'size="9"' : '';?> value="<?=form_prep($item->{$field->name})?>"/>
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

<input type="submit" value="update"/>

</form>

<?php $this->view("footer"); ?>

