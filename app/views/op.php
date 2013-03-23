<?php $this->load->view('header'); ?>

<h2>alter '<?=$op->name?>'</h2>

<div class="help">
 <p>This page allows you to alter operation definitions (queries) for your collectibles.</p>
 <p>For the role, enter the name of a user-group that should be allowed to perform this operation.
  If multiple user-groups are allowed to execute the operation, separate the user-group names with a
  comma (,). If the operation can be executed by any user-group, leave the field blank.</p>
</div>

<?=form_open('/application/operation_alter/'.$op->id)?>

<?=validation_errors()?>

<p>
 <label>operation name</label><br/>
 <input type="text" name="name" value="<?=set_value('name', $op->name)?>"/>
</p>
<p>
 <label>role</label><br/>
 <input type="text" name="role" value="<?=set_value('role', $op->role)?>"/>
</p>
<p>
 <label>main menu?</label><br/>
 no: <input type="radio" name="main_menu" value="0" <?=set_radio('main_menu', 'checked', $op->main_menu == 0)?>>&nbsp;&nbsp;&nbsp;
 yes: <input type="radio" name="main_menu" value="1" <?=set_radio('main_menu', 'checked', $op->main_menu == 1)?>>
</p>
<p>
 <label>sql</label><br/>
 <textarea name="sql_text" rows="5" cols="65"><?=set_value('sql_text', $op->sql_text)?></textarea>
</p>
<p>
 <label>has view?</label><br/>
 no: <input type="radio" name="has_view" value="0" <?=set_radio('has_view', 'checked', $op->has_view == 0)?>>&nbsp;&nbsp;&nbsp;
 yes: <input type="radio" name="has_view" value="1" <?=set_radio('has_view', 'checked', $op->has_view == 1)?>><br/>
 <textarea name="view_code" rows="5" cols="65"><?=set_value('view_code', $op->view_code)?></textarea>
</p>
<input type="submit" value="alter definition"/>
</form>

<p><a href="/application/operation_delete/<?=$op->id?>">Delete</a> this operation</p>

<?php $this->load->view('footer'); ?>

