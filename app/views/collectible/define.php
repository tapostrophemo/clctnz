<?php $this->view("header"); ?>

<h2>define collectible</h2>

<div class="help">
 <p>This page allows you to define new "data types" - the type of collectible items.</p>
 <p>For example, you might want to collect yo-yos. You would enter "yoyo" in the "collectible name"
  field, then you would choose the attributes of a yo-yo. For example, a yo-yo might have:</p>
 <ul>
  <li>manufacturer</li>
  <li>model name</li>
  <li>model year</li>
  <li>original price</li>
  <li>condition</li>
 </ul>
</div>

<?=form_open('collectible/define')?>

<?=validation_errors()?>

<p><label>collectible name</label> <input type="text" name="collectible_name"/></p>
<fieldset id="attributes"><legend>attributes</legend>
 <p id="firstAttribute">
  <label>attribute name</label> <input type="text" name="attribute_name[]"/>
  <label>type of data</label>
  <select name="attribute_type[]">
   <option value="int">number</option>
   <option value="varchar">text (short)</option>
   <option value="text">text (long)</option>
  </select>
 </p>
 <p><a href="#" id="newAttribute">new attribute</a></p>
</fieldset>
<input type="submit" value="save definition"/>

</form>

<script type="text/javascript">
$(document).ready(function () {
  $("#newAttribute").click(function () {
    var $a = $("#firstAttribute").clone();
    var $d = $("<a href=\"#\">delete attribute</a>").click(function () {$a.remove();});
    $a.append($d);
    $a.insertBefore($("#attributes").children().last());
    $a.find("input").focus().select();
  });
});
</script>

<?php $this->view("footer"); ?>

