<?php

class Collectible extends CI_Controller
{
  function define() {
    if (!$this->form_validation->run('collectible_define')) {
      $this->load->view('collectible/define');
    }
    else {
      $tableName = strtolower($this->input->post('collectible_name'));
      $names = $this->input->post('attribute_name');
      $types = $this->input->post('attribute_type');
      $fields = array();
      for ($i = 0; $i < count($names); $i++) {
        $name = preg_replace('/\s/', '_', strtolower($names[$i]));
        $fields[$name] = array('type' => $types[$i]);
        if ($types[$i] == 'varchar') $fields[$name]['constraint'] = 255;
        if ($types[$i] == 'int') $fields[$name]['constraint'] = 10;
      }
      $this->load->dbforge();
      $this->dbforge->add_field('id');
      $this->dbforge->add_field($fields);
      $this->dbforge->create_table($tableName, true);
      $this->dbforge->add_key('id', true);

      redirect('/');
    }
  }

  function add() {
    $this->load->view('collectible/add');
  }

  function edit() {
    $this->load->view('collectible/edit');
  }

  function all() {
    $this->load->view('collectible/all');
  }
}

