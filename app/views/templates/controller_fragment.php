<?php
$name = str_replace(' ', '_', $op->name);

$sql = $op->sql_text;

if (false === strpos($sql, "\n")) {
  list($args, $params) = parseSql($sql);
}
else {
  $sql = explode("\n", $sql);
  foreach ($sql as $s) {
    list($a, $p) = parseSql($s);
    $args[] = $a;
    $params[] = $p;
  }
  $args = implode(', ', $args);
}
?>
  function <?=$name?>(<?=$args?>) {
    <?php if (!empty($op->role)): ?>if ($this->session->userdata('role') != '<?=$op->role?>')) {
      $this->session->set_flashdata('err', 'Unauthorized!');
      redirect('/');
    }
    <?php endif; ?>

    <?php if (!is_array($params)): ?>$this->db->query('<?=$sql?>', array(<?=$params?>));
    <?php else: ?><?php for ($i = 0; $i < count($sql); $i++): ?>$this->db->query('<?=$sql[$i]?>', array(<?=$params[$i]?>));
    <?php endfor; ?>
    <?php endif; ?>

  }
