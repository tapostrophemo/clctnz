<script type="text/javascript">
$(document).ready(function () {
  $("#newAttribute").click(function () {
    var $a = $("#firstAttribute").clone();
    var $d = $("<a href=\"#\">delete attribute</a>").click(function () {$a.remove();});
    $a.append($d);
    $a.insertBefore($("#attributes").children().last());
    $a.find("input").focus().select();
    return false;
  });
});
</script>

