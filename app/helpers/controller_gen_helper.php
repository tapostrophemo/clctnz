<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/********************************************************************************/
function roleCheck($role) {
  if (!empty($role)): ?>if ($this->session->userdata('role') != '<?=$role?>') {
      $this->session->set_flashdata('err', 'Unauthorized!');
      redirect('/');
    }
<?php endif;
}

/********************************************************************************/
function validationCheck($name) {
?>if (!$this->form_validation->run('<?=$name?>')) {
      $this->load->view('<?=$name?>');
    }
<?php
}

/********************************************************************************/
function generateFromInsert($parser, $name, $sql, $role = '') {
?>
  function <?=$name?>() {
    <?php roleCheck($role); ?>

    <?php validationCheck($name); ?>
    else {
<?php foreach ($parser->parsed['INSERT']['columns'] as $col): $colnames[] = $colname = $col['base_expr']; ?>
      $<?=$colname?> = $this->input->post('<?=$colname?>');
<?php endforeach; ?>
      $this->db->query('<?=$sql?>', array($<?=implode(', $', $colnames)?>));
    }
  }
<?php
}

/********************************************************************************/
function generateFromUpdate($parser, $name, $sql, $role = '') {
  // TODO: loop over values/where-criteria
  $values = $parser->parsed['SET'][0]['sub_tree'][0]['base_expr'];
  $where = $parser->parsed['WHERE'][0]['base_expr'];
?>
  function <?=$name?>() {
    <?php roleCheck($role); ?>

    <?php validationCheck($name); ?>
    else {
      $<?=$values?> = $this->input->post('<?=$values?>');
      $<?=$where?> = $this->input->post('<?=$where?>');
      $this->db->query('<?=$sql?>', array($<?=$values?>, $<?=$where?>));
    }
  }
<?php
}

/********************************************************************************/
function generateFromDelete($parser, $name, $sql, $role = '') {
  // TODO: loop over where-criteria
  $where = $parser->parsed['WHERE'][0]['base_expr'];
?>
  function <?=$name?>() {
    <?php roleCheck($role); ?>

    <?php validationCheck($name); ?>
    else {
      $<?=$where?> = $this->input->post('<?=$where?>');
      $this->db->query('<?=$sql?>', array($<?=$where?>));
    }
  }
<?php
}

/********************************************************************************/
function generateFromMulti($name, $sqls, $role = '') {
  // TODO: loop over critera; handle INSERTs, UPDATEs, and mixed combos too (!)
?>
  function <?=$name?>() {
    <?php roleCheck($role); ?>

    <?php validationCheck($name); ?>
    else {<?php foreach ($sqls as $sql):
            $parser = new PHPSQLParser($sql);
            $where = $parser->parsed['WHERE'][0]['base_expr']; ?>

      $<?=$where?> = $this->input->post('<?=$where?>');
      $this->db->query('<?=$sql?>', array($<?=$where?>));
<?php endforeach; ?>
    }
  }
<?php
}

/********************************************************************************/
function generateFromSelect($parser, $name, $sql, $role = '') {
  $items = $parser->parsed['FROM'][0]['table'];
?>
  function <?=$name?>() {
    <?php roleCheck($role); ?>

    $<?=$items?> = $this->db->query('<?=$sql?>')->result();
    $this->load->view('<?=$name?>', array('<?=$items?>' => $<?=$items?>));
  }
<?php
}
