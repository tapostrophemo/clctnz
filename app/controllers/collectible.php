<?php

class Collectible extends CI_Controller
{
  function __construct() {
    parent::__construct();
    $this->load->model('CollectionApp');
    $this->load->dbforge();
  }

  function define() {
    if (!$this->form_validation->run('collectible_define')) {
      // TODO: more validation:
      // - "id" is reserved name
      // - must have unique attribute names
      // - must have at least 1st attribute name
      // - must have equal numbers of names/types
      // - validate selected types are allowed
      $this->load->view('collectible/define');
    }
    else {
      $tableName = underscore($this->input->post('collectible_name'));
      $fields = $this->setupColumnFields();
      $this->dbforge->add_field('id');
      $this->dbforge->add_field($fields);
      $this->dbforge->create_table($tableName, true);

      redirect('/');
    }
  }

  function alter($collectible) {
    if (!$this->form_validation->run('collectible_alter')) {
      $sql = $this->CollectionApp->getSql($collectible);
      $d = $this->db->query('describe ' . $this->db->escape_str($collectible))->result_array();
      $this->load->view('collectible/alter', array('collectible' => $collectible, 'sql' => $sql, 'description' => $d));
    }
    else {
      $fields = $this->setupColumnFields();
      $this->dbforge->add_column($collectible, $fields);
      redirect('/');
    }
  }

  function alter_delete($collectible, $attribute) {
    $this->dbforge->drop_column($collectible, $attribute);
    redirect('/');
  }

  private function setupColumnFields() {
    $names = $this->input->post('attribute_name');
    $types = $this->input->post('attribute_type');
    $fields = array();
    for ($i = 0; $i < count($names); $i++) {
      $name = underscore($names[$i]);
      $fields[$name] = array('type' => $types[$i]);
      if ($types[$i] == 'varchar') $fields[$name]['constraint'] = 255;
      if ($types[$i] == 'int') $fields[$name]['constraint'] = 10;
    }
    return $fields;
  }

  function rename($collectible) {
    if (!$this->form_validation->run('collectible_rename')) {
      $this->load->view('collectible/rename', array('collectible' => $collectible));
    }
    else {
      $this->dbforge->rename_table($collectible, $this->input->post('collectible_name'));
      redirect('/');
    }
  }

  function delete($collectible) {
    $this->dbforge->drop_table($collectible);
    redirect('/');
  }

  function items() {
    $tables = $this->CollectionApp->getTables();
    $this->load->view('data', array('tables' => $tables));
  }
}

