<?php

class CollectionApp extends CI_Model
{
  function getTables() {
    return array_filter($this->db->list_tables(), array($this, 'isReservedTable'));
  }

  private function isReservedTable($name) {
    return !in_array($name, array('_clctnz_operations', '_clctnz_application'));
  }

  function getSql($collectible) {
    $c = $this->db->query('show create table ' . $this->db->escape_str($collectible))->result_array();
    return $c[0]['Create Table'];
  }

  function getOperations() {
    return $this->db->select(array('id', 'name', 'role', 'main_menu', 'has_view'))->get('_clctnz_operations')->result();
  }

  function getOperation($id) {
    return $this->db->where('id', $id)->get('_clctnz_operations')->row();
  }

  function saveOperation($name, $role, $mainMenu, $sqlText, $hasView, $viewCode) {
    $this->db->insert('_clctnz_operations', array(
      'name' => $name,
      'role' => $role,
      'main_menu' => $mainMenu,
      'sql_text' => $sqlText,
      'has_view' => $hasView,
      'view_code' => $viewCode));
  }

  function updateOperation($id, $name, $role, $mainMenu, $sqlText, $hasView, $viewCode) {
    $this->db->where('id', $id)->update('_clctnz_operations', array(
      'name' => $name,
      'role' => $role,
      'main_menu' => $mainMenu,
      'sql_text' => $sqlText,
      'has_view' => $hasView,
      'view_code' => $viewCode));
  }

  function deleteOperation($id) {
    $this->db->where('id', $id)->delete('_clctnz_operations');
  }

  function getDatabaseSettings() {
    $sql = "
      SELECT IfNull(value, '') AS value FROM _clctnz_application WHERE name = 'db_hostname'
      UNION ALL
      SELECT IfNull(value, '') AS value FROM _clctnz_application WHERE name = 'db_username'
      UNION ALL
      SELECT IfNull(value, '') AS value FROM _clctnz_application WHERE name = 'db_password'
      UNION ALL
      SELECT IfNull(value, '') AS value FROM _clctnz_application WHERE name = 'db_database'";
    $result = $this->db->query($sql)->result();
    return array(
      'hostname' => $result[0]->value,
      'username' => $result[1]->value,
      'password' => $result[2]->value,
      'database' => $result[3]->value);
  }

  function updateDatabaseSettings($hostname, $username, $password, $database) {
    $this->db->query("UPDATE _clctnz_application SET value = ? WHERE name = 'db_hostname'", $hostname);
    $this->db->query("UPDATE _clctnz_application SET value = ? WHERE name = 'db_username'", $username);
    $this->db->query("UPDATE _clctnz_application SET value = ? WHERE name = 'db_password'", $password);
    $this->db->query("UPDATE _clctnz_application SET value = ? WHERE name = 'db_database'", $database);
  }

  function getHeaderFooter() {
    $sql = "
      SELECT IfNull(value, '') AS value FROM _clctnz_application WHERE name = 'header'
      UNION ALL
      SELECT IfNull(value, '') AS value FROM _clctnz_application WHERE name = 'footer'";
    $result = $this->db->query($sql)->result();
    $hf = new stdClass;
    $hf->header = $result[0]->value;
    $hf->footer = $result[1]->value;
    return $hf;
  }

  function updateHeaderFooter($header, $footer) {
    $this->db->query("UPDATE _clctnz_application SET value = ? WHERE name = 'header'", $header);
    $this->db->query("UPDATE _clctnz_application SET value = ? WHERE name = 'footer'", $footer);
  }

  function getStyle() {
    return $this->db->query("SELECT IfNull(value, '') AS style FROM _clctnz_application WHERE name = 'style'")->row();
  }

  function updateStyle($style) {
    $this->db->query("UPDATE _clctnz_application SET value = ? WHERE name = 'style'", $style);
  }
}

