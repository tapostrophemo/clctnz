<?php $this->load->view('header'); ?>

<h2>edit application header/footer</h2>

<div class="help">
 <p>This page allows you to set the HTML text of shared header and footer regions in your application.</p>
</div>

<?=form_open('/application/header_footer')?>
 <?=validation_errors()?>
 <label>header (HTML)</label><br/>
 <textarea name="header" rows="11" cols="105" wrap="off"><?=form_prep($header)?></textarea><br/>
 <br/>
 <label>footer (HTML)</label><br/>
 <textarea name="footer" rows="11" cols="105" wrap="off"><?=form_prep($footer)?></textarea><br/>
 <input type="submit" value="save"/>
</form>

<?php $this->load->view('footer'); ?>

