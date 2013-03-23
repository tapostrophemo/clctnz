<?php

$name = str_replace(' ', '_', $op->name);
$sql = $op->sql_text;

if (false !== strpos($sql, "\n")) {
  $sql = explode("\n", $sql);
}

if (!is_array($sql)) {
  $p = new PHPSQLParser($sql);
  if (isset($p->parsed['INSERT'])) generateFromInsert($p, $name, $sql, $op->role);
  if (isset($p->parsed['UPDATE'])) generateFromUpdate($p, $name, $sql, $op->role);
  if (isset($p->parsed['DELETE'])) generateFromDelete($p, $name, $sql, $op->role);
  if (isset($p->parsed['SELECT'])) {
    if (isset($p->parsed['WHERE']))
      generateFromSelectWhere($p, $name, $sql, $op->role);
    else
      generateFromSelect($p, $name, $sql, $op->role);
  }
}
else {
  generateFromMulti($name, $sql, $op->role);
}
