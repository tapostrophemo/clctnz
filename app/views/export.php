<?php $this->view("header"); ?>

<h2>application export</h2>

<div class="help">
 <p>This page alows you to export all current collectibles as an application.</p>
</div>

<p>
 <a href="#" id="toggleAll">Toggle all files</a>
 &nbsp;
 <a href="#" id="download">Download *.zip</a>
 <form id="downloadForm" method="post" action="/application/export">
  <input type="hidden" name="to_file" value="true"/>
 </form>
</p>

<?php foreach ($code as $file): ?>
<?php if (substr($file['name'], -4) == '.php'): ?>
<pre><?=$file['name']?> <div class="collapsed"><?php highlight_string($file['code']); ?></div></pre>
<?php else: ?>
<pre><?=$file['name']?> <code class="collapsed"><?=htmlspecialchars($file['code'])?></code></pre>
<?php endif; ?>
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
    return false;
  });

  $("#download").click(function () {
    $("#downloadForm").submit();
    return false;
  });
});
</script>

<?php $this->view("footer"); ?>

