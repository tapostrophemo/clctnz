<?php $this->load->view('header'); ?>

<h2>define operation</h2>

<div class="help">
 <p>This page allows you to define operations (queries) on your collectibles.</p>
</div>

<?=form_open('/application/operation')?>

<?=validation_errors()?>

<p><label>Operation name</label> <input type="text" name="name"/></p>
<p><label>SQL</label><br/><textarea name="sql_text" rows="5" cols="65"></textarea></p>
<p><input type="submit" value="save definition"/></p>
</form>

<?php $this->load->view('footer'); ?>

