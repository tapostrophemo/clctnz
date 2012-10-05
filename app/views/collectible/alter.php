<?php $this->view("header"); ?>

<h2>alter <?=$collectible?></h2>

<div class="help">
 <p>This page allows you to alter the description of a "collection", i.e., of a certain type.</p>
</div>

<p>The SQL to create the table '<?=$collectible?>' is currently:</p>
<pre><code><?=$sql?></code></pre>

<?=form_open("collectible/alter/$collectible")?>

<?=validation_errors()?>

<fieldset id="attributes"><legend>add attributes</legend>
 <p id="firstAttribute">
  <label>attribute name</label> <input type="text" name="attribute_name[]"/>
  <label>type of data</label>
  <select name="attribute_type[]">
   <option value="int">number</option>
   <option value="varchar">text (short)</option>
   <option value="text">text (long)</option>
   <option value="date">date</option>
  </select>
 </p>
 <p><!--a href="#" id="newAttribute">new attribute</a--></p>
</fieldset>
<input type="submit" value="alter definition"/>

</form>

<p>
 <a href="/collectible/delete/<?=$collectible?>"/>Delete</a> /
 <a href="/collectible/rename/<?=$collectible?>">rename</a>
 <?=$collectible?> table
</p>

<!--
TODO: check for CI fix to issue ADDing multiple columns via dbforge (or fork it and fix it myself)
<?php $this->view("scripts/attributes"); ?>
-->

<?php $this->view("footer"); ?>

