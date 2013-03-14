<?php $this->load->view('header'); ?>

<h2>define operation</h2>

<div class="help">
 <p>This page allows you to define operations (queries) on your collectibles.</p>
 <p>For the role, enter the name of a user-group that should be allowed to perform this operation.
  If multiple user-groups are allowed to execute the operation, separate the user-group names with a
  comma (,). If the operation can be executed by any user-group, leave the field blank.</p>
</div>

<?=form_open('/application/operation')?>

<?=validation_errors()?>

<p>
 <label>operation name</label><br/>
 <input type="text" name="name"/>
</p>
<p>
 <label>role</label><br/>
 <input type="text" name="role"/>
</p>
<p>
 <label>sql</label><br/>
 <textarea name="sql_text" rows="5" cols="65"></textarea>
</p>
<p>
 <label>has view?</label><br/>
 no: <input type="radio" name="has_view" value="0">&nbsp;&nbsp;&nbsp;
 yes: <input type="radio" name="has_view" value="1"><br/>
 <textarea name="view_code" rows="5" cols="65"></textarea>
</p>
<input type="submit" value="save definition"/>
</form>

<?php $this->load->view('footer'); ?>

