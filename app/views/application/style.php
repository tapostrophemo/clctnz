<?php $this->load->view('header'); ?>

<h2>edit application style</h2>

<div class="help">
 <p>This page allows you to set the CSS for your application.</p>
</div>

<?=form_open('/application/style')?>
 <?=validation_errors()?>
 <label>style (CSS)</label><br/>
 <textarea name="style" rows="11" cols="105" wrap="off"><?=form_prep($style)?></textarea><br/>
 <input type="submit" value="save"/>
</form>

<?php $this->load->view('footer'); ?>

