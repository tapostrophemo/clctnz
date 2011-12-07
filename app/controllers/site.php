<?php

class Site extends CI_Controller
{
  function index() {
    $this->load->model('CollectionApp');
    $this->load->view('menu', array('collectibles' => $this->CollectionApp->getTables()));
  }
}

