<?php if ($_SERVER['PHP_SELF'] != '/index.php'): ?>
<p><a href="/">Home</a></p>
<?php endif; ?>

<div id="footer">
 <p>Copyright &copy; 2011, Dan Parks. All Rights Reserved.</p>
</div>

<script type="text/javascript">
$(document).ready(function () {
  $("<a href=\"#\">Show help</a>")
    .insertBefore(".help")
    .click(function () {
      $(".help").slideDown().removeClass("help");
      $(this).slideUp();
    });
});
</script>

</body>
</html>

