<?php $this->view("header"); ?>

<h2>add <?=$collectible?></h2>

<div class="help">
 <p>This page allows you to add a new collectible.</p>
</div>

<?=form_open("collectible/add/$collectible")?>

<?=validation_errors()?>

<?php foreach ($fields as $field): if ($field->name != 'id'): ?>
<p>
 <label><?=preg_replace('/_/', ' ', $field->name)?></label><br/>
<?php if ($field->type != 'blob'): ?>
 <input type="text" name="<?=$field->name?>" <?=$field->type == 'int' ? 'size="9"' : '';?>/>
<?php else: ?>
 <textarea name="<?=$field->name?>" rows="3" cols="35"></textarea>
<?php endif; ?>
</p>
<?php endif; endforeach; ?>

<input type="submit" value="save"/>

</form>

<?php $this->view("footer"); ?>

