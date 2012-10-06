<?php

class CollectionItems extends CI_Model
{
  function getItem($collectible, $id) {
    $query = $this->db->where('id', $id)->get($collectible);
    return $query->row();
  }

  function deleteItem($collectible, $id) {
    return $this->db->where('id', $id)->delete($collectible);
  }
}

