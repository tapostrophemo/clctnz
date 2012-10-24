<?php

class Site extends CI_Controller
{
  function index() {
    $this->load->model('CollectionApp');
    $cols = $this->CollectionApp->getTables();
    $ops = $this->CollectionApp->getOperations();
    $this->load->view('menu', array('collectibles' => $cols, 'operations' => $ops));
  }
}

