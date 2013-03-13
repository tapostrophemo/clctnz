<?php $this->load->view('header'); ?>

<h2>manage database settings</h2>

<div class="help">
 <p>This page allows you to manage the database settings for your application.</p>
</div>

<?=form_open('/application/database')?>
 <?=validation_errors()?>
 <p>
  <label>hostname</label><br/>
  <input type="text" name="hostname" value="<?=set_value('hostname', $hostname)?>"/>
 </p>
 <p>
  <label>username</label><br/>
  <input type="text" name="username" value="<?=set_value('username', $username)?>"/>
 </p>
 <p>
  <label>password</label><br/>
  <input type="text" name="password" value="<?=set_value('password', $password)?>"/>
 </p>
 <p>
  <label>database</label><br/>
  <input type="text" name="database" value="<?=set_value('database', $database)?>"/>
 </p>
 <input type="submit" value="save"/>
</form>

<?php $this->load->view('footer'); ?>

