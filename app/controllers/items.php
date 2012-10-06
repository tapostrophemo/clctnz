<?php

class Items extends CI_Controller
{
  function __construct() {
    parent::__construct();
    $this->load->model('CollectionApp');
    $this->load->model('CollectionItems');
  }

  function index() {
    $tables = $this->CollectionApp->getTables();
    $this->load->view('data', array('tables' => $tables));
  }

  function add($collectible) {
    // TODO: validate that $collectible has been defined

    $fields = $this->db->field_data($collectible);

    if (!$this->form_validation->run('item_save')) {
      $refs = $this->getRefs($fields);
      $this->load->view('items/add', array('collectible' => $collectible, 'fields' => $fields, 'refs' => $refs));
    }
    else {
      $data = array();
      foreach ($fields as $field) {
        $name = $field->name;
        if ($name == 'id') continue;
        $value = $this->input->post($name);
        $data[$name] = $value;
      }
      $this->db->insert($collectible, $data);
      redirect("/items/all/$collectible");
    }
  }

  function item_save_valid($junk) {
/*echo '<pre>';
$segments = $this->uri->segment_array();
print_r($segments);
$fields = $this->db->field_data($segments[3]); // TODO: if (!isset(...
print_r($fields);
echo '</pre>';
*/
  }

  function delete($collectible, $id) {
    $this->CollectionItems->deleteItem($collectible, $id);
    redirect("/items/all/$collectible");
  }

  function edit($collectible, $id) {
    // TODO: refactor this (and 'add' above); this chunk is nearly identical

    $fields = $this->db->field_data($collectible);

    if (!$this->form_validation->run('item_save')) {
      $refs = $this->getRefs($fields);
      $item = $this->CollectionItems->getItem($collectible, $id);
      $this->load->view('items/edit', array('collectible' => $collectible, 'item' => $item, 'fields' => $fields, 'refs' => $refs));
    }
    else {
      $data = array();
      foreach ($fields as $field) {
        $name = $field->name;
        if ($name == 'id') continue;
        $value = $this->input->post($name);
        $data[$name] = $value;
      }
      $this->db->where('id', $id)->update($collectible, $data);
      redirect("/items/all/$collectible");
    }
  }

  private function getRefs($fields) {
    $refs = array();
    $tables = $this->CollectionApp->getTables();
    foreach ($fields as $field) {
      // find references to foreign-key; TODO: would be better to use and rely on DB FK metadata
      if (substr($field->name, -3) == '_id') {
        foreach ($tables as $table) {
          if (strpos($table, substr($field->name, 0, -3)) !== false) {
            $refs[$field->name] = $table;
          }
        }
      }
    }
    return $refs;
  }

  function all($collectible) {
    $fields = $this->db->field_data($collectible);
    $data = $this->db->get($collectible)->result_array();
    $this->load->view('items/all', array('collectible' => $collectible, 'fields' => $fields, 'data' => $data));
  }

  function backup() {
    require APPPATH.'config/database.php'; // NB: I wish CI had a way to access these in a less-hacky way
    $command = 'mysqldump -u '.$db['default']['username'].' -p'.$db['default']['password'].' '.$db['default']['database'].' --compact --no-create-info';
    $data = `$command`;
    $this->load->helper('download');
    force_download('collectible_items_data.sql', $data);
  }
}

