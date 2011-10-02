<?php

class Site extends CI_Controller
{
  function index() {
    $tables = $this->db->list_tables();
    $this->load->view('menu', array('collectibles' => $tables));
  }
}

