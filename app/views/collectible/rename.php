<?php $this->view('header'); ?>

<h2>rename <?=$collectible?></h2>

<div class="help">
 <p>This page allows you to rename the table in which a collectible type is stored.</p>
</div>

<p>Rename the '<?=$collectible?>' table:</p>

<?=form_open('collectible/rename/'.$collectible)?>
 <?=validation_errors()?>
 <input type="text" name="collectible_name"/>
 <input type="submit" value="Rename table"/>
</form>

<?php $this->view('footer'); ?>

