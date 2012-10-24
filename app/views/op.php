<?php $this->load->view('header'); ?>

<h2>define operation</h2>

<div class="help">
 <p>This page allows you to alter operation definitions (queries) for your collectibles.</p>
</div>

<?=form_open('/application/operation_alter/'.$op->id)?>

<?=validation_errors()?>

<p><label>Operation name</label> <input type="text" name="name" value="<?=set_value('name', $op->name)?>"/></p>
<p><label>SQL</label><br/><textarea name="sql_text" rows="5" cols="65"><?=set_value('sql_text', $op->sql_text)?></textarea></p>
<p><input type="submit"/></p>
</form>

<p><a href="/application/operation_delete/<?=$op->id?>">Delete</a> this operation</p>

<?php $this->load->view('footer'); ?>

