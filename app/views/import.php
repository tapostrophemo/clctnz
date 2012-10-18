<?php $this->load->view('header'); ?>

<h2>import</h2>

<p>Paste SQL code below to create a set of tables for storing your "collectibles".</p>

<?=form_open("/application/import")?>

<?=validation_errors()?>

<textarea name="sql" rows="11" cols="75"></textarea>
<br/>
<input type="submit" value="import"/>

</form>

<?php $this->load->view('footer'); ?>

