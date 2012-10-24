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
}

