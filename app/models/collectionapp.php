<?php

class CollectionApp extends CI_Model
{
  function getTables() {
    return $this->db->list_tables();
  }

  function getSql($collectible) {
    $c = $this->db->query('show create table ' . $this->db->escape_str($collectible))->result_array();
    return $c[0]['Create Table'];
  }
}

