<?php

class Collectible extends CI_Controller
{
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
      $tableName = preg_replace('/ /', '_', strtolower($this->input->post('collectible_name')));
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

      redirect('/');
    }
  }

  function alter($collectible) {
    if (!$this->form_validation->run('collectible_alter')) {
      $this->load->model('CollectionApp');
      $sql = $this->CollectionApp->getSql($collectible);
      $d = $this->db->query('describe ' . $this->db->escape_str($collectible))->result_array();
      $this->load->view('collectible/alter', array('collectible' => $collectible, 'sql' => $sql, 'description' => $d));
    }
    else {
      $this->load->dbforge();
      $this->dbforge->rename_table($collectible, $this->input->post('collectible_name'));
      redirect('/');
    }
  }

  function delete($collectible) {
    $this->load->dbforge();
    $this->dbforge->drop_table($collectible);
    redirect('/');
  }

  function add($collectible) {
    // TODO: validate that $collectible has been defined
    $fields = $this->db->field_data($collectible);
    if (!$this->form_validation->run('collectible_save')) {
      $this->load->view('collectible/add', array('collectible' => $collectible, 'fields' => $fields));
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
      redirect("/collectible/all/$collectible");
    }
  }

  function collectible_save_valid($junk) {
/*echo '<pre>';
$segments = $this->uri->segment_array();
print_r($segments);
$fields = $this->db->field_data($segments[3]); // TODO: if (!isset(...
print_r($fields);
echo '</pre>';
*/
  }

  function edit() {
    $this->load->view('collectible/edit');
  }

  function all($collectible) {
    $fields = $this->db->field_data($collectible);
    $data = $this->db->get($collectible)->result_array();
    $this->load->view('collectible/all', array('collectible' => $collectible, 'fields' => $fields, 'data' => $data));
  }
}

