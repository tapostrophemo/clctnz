<?php $this->view("header"); ?>

<h2>application export</h2>

<div class="help">
 <p>This page alows you to export all current collectibles as an application.</p>
</div>

<p><a href="#" id="toggleAll">Toggle all files</a></p>

<h3>database</h3>
<pre>setup.sql <code class="collapsed"><?=$sql?></code></pre>

<h3>code</h3>
<?php foreach ($code as $file): ?>
<pre><?=$file['name']?> <code class="collapsed"><?=$file['code']?></code></pre>
<?php endforeach; ?>

<script type="text/javascript">
$(document).ready(function () {
  $.each($(".collapsed"), function (i, section) {
    var $section = $(section);
    var $toggle = $("<a class=\"toggle\" href=\"#\">show/hide</a>").click(function () {$section.toggleClass("collapsed"); return false;});
    $toggle.insertBefore($section);
  });

  $("#toggleAll").click(function () {
    $.each($(".toggle"), function (i, link) {$(link).click();});
  });
});
</script>

<?php $this->view("footer"); ?>

