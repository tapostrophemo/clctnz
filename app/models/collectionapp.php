<?php

class CollectionApp extends CI_Model
{
  function getTables() {
    return array_filter($this->db->list_tables(), array($this, 'isReservedTable'));
  }

  private function isReservedTable($name) {
    return !in_array($name, array('_clctnz_operations'));
  }

  function getSql($collectible) {
    $c = $this->db->query('show create table ' . $this->db->escape_str($collectible))->result_array();
    return $c[0]['Create Table'];
  }

  function getOperations() {
    return $this->db->select(array('id', 'name', 'role'))->get('_clctnz_operations')->result();
  }

  function getOperation($id) {
    return $this->db->where('id', $id)->get('_clctnz_operations')->row();
  }

  function saveOperation($name, $role, $sqlText) {
    $this->db->insert('_clctnz_operations', array('name' => $name, 'role' => $role, 'sql_text' => $sqlText));
  }

  function updateOperation($id, $name, $role, $sqlText) {
    $this->db->where('id', $id)->update('_clctnz_operations', array('name' => $name, 'role' => $role, 'sql_text' => $sqlText));
  }

  function deleteOperation($id) {
    $this->db->where('id', $id)->delete('_clctnz_operations');
  }
}

