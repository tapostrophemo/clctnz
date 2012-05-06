<?php

class Site extends CI_Controller
{
  function index() {
    $this->load->view('menu');
  }

  function login() {
    echo 'TODO: implement site login';
  }

  function logout() {
    echo 'TODO: implement site logout';
  }

  function register() {
    echo 'TODO: implement site registration';
  }

  function reset() {
    echo 'TODO: implement password reset';
  }
}

