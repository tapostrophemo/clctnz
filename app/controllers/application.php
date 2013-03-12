<?php
require_once(APPPATH.'../lib/PHP-SQL-Parser/php-sql-parser.php');

function getTemplate($path, $replacement = null) {
  if (!$replacement) {
    return getFile($path);
  }
  return
    str_replace('$collectible', $replacement,
      str_replace('<?=$collectible?>', $replacement, file_get_contents(APPPATH.$path)));
}

function getFile($path) {
  return file_get_contents(APPPATH.$path);
}

class Application extends CI_Controller
{
  function __construct() {
    parent::__construct();
    $this->load->model('CollectionApp');
    $this->load->helper('controller_gen');
  }

  function export() {
    $collections = $this->CollectionApp->getTables();
    $operations = $this->CollectionApp->getOperations();
    $code = $this->generateCode($collections, $operations);
    if ($this->input->post('to_file') == true) {
      $this->downloadAsZip($code);
    }
    else {
      $this->load->view('export', array('code' => $code));
    }
  }

  private function generateController($operations) {
    $methods = array();
    foreach ($operations as $op) {
      $oop = $this->CollectionApp->getOperation($op->id);
      $methods[] = $this->load->view('templates/app/controllers/controller_fragment', array('op' => $oop), true);
    }
    return getTemplate('views/templates/app/controllers/application.php', implode("\n", $methods));
  }

  private function generateModel() {
    return getTemplate('views/templates/app/models/model.php');
  }

  private function generateCode($collectibles, $operations) {
    $code = array();

    $code[] = array('name' => "app/config/autoload.php", 'code' => getTemplate('views/templates/app/config/autoload.php', "'Model'"));
    $code[] = array('name' => "app/config/database.php", 'code' => getTemplate('views/templates/app/config/database.php'));
    $config = array();
//$config[] = print_r($operations, true);
    foreach ($operations as $op) {
      $name = str_replace(' ', '_', $op->name);
      $config[] = "  '$name' => array('field' => 'TODO', 'label' => 'TODO', 'rules' => 'TODO'),";
    }
    $code[] = array('name' => "app/config/form_validation.php", 'code' => getTemplate('views/templates/app/config/form_validation.php', join($config, "\n")));

    $routes = $this->load->view('templates/app/config/route_fragment', array('operations' => $operations), true);
    $code[] = array('name' => 'app/config/routes.php', 'code' => getTemplate('views/templates/app/config/routes.php', $routes));
    $code[] = array('name' => 'app/controllers/application.php', 'code' => $this->generateController($operations));
    $code[] = array('name' => 'app/controllers/site.php', 'code' => getTemplate('views/templates/app/controllers/site.php'));
    $code[] = array('name' => 'app/models/model.php', 'code' => $this->generateModel());
    // NB: Model empty for now; putting all the DB stuff in the 'operation' in app controller

    $appData = $this->CollectionApp->getHeaderFooter();
    $code[] = array('name' => 'app/views/header.php', 'code' => $appData->header);
    $code[] = array('name' => 'app/views/menu.php', 'code' => $this->load->view('templates/app/views/menu', array('operations' => $operations), true));
    $code[] = array('name' => 'app/views/footer.php', 'code' => $appData->footer);

    $sql = array("-- setup");
    foreach ($collectibles as $collectible) {
      $s = $this->CollectionApp->getSql($collectible);
      $sql[] = preg_replace("/AUTO_INCREMENT=\d+ /", "", $s);
    }
    $sql[] = "\n\n-- triggers";
    foreach ($this->db->query('show triggers')->result() as $trigger) {
      $spec = $this->db->query('show create trigger ' . $trigger->Trigger)->row();
      $osql = $spec->{'SQL Original Statement'};
      $sql[] = preg_replace("/CREATE DEFINER=.* TRIGGER/", 'CREATE TRIGGER', $osql);
    }
    $code[] = array('name' => 'sql/setup.sql', 'code' => join($sql, ";\n\n") . ';');
    $ops = array();
    foreach ($operations as $op) {
      $s = $this->CollectionApp->getOperation($op->id)->sql_text;
      $ss = preg_replace("/\n/", "\\n", $s);
      $ops[] = "/*\n-- {$op->name}\n" . $s . "\n*/";
      $ops[] = "INSERT INTO _clctnz_operations(name, role, sql_text) VALUES('{$op->name}', '{$op->role}', '{$ss}');\n";
    }
    $code[] = array('name' => 'sql/operations.sql', 'code' => join($ops, "\n\n"));
    $code[] = array('name' => 'sql/teardown.sql', 'code' => "DROP TABLE IF EXISTS\n  " . join($collectibles, ",\n  ") . ';');

    $code[] = array('name' => 'web/index.php', 'code' => getTemplate('../web/index.php'));
    $code[] = array('name' => 'web/.htaccess', 'code' => getTemplate('../web/.htaccess'));
    $appData = $this->CollectionApp->getStyle();
    $code[] = array('name' => 'web/res/style.css', 'code' => $appData->style);

    return $code;
  }

  private function downloadAsZip($code) {
    $this->load->library('zip');

    $this->zip->read_dir(BASEPATH.'../../lib/', false);
    // want 'lib' to be in 'application/lib'
    $t = tempnam('/tmp', '_clctnz_');
    $this->zip->archive($t);
    shell_exec("mkdir -p /tmp/foo/application");
    shell_exec("unzip -d /tmp/foo $t");
    shell_exec("mv /tmp/foo/lib /tmp/foo/application");
    $this->zip->clear_data();
    $this->zip->read_dir('/tmp/foo/application/', false);
    shell_exec("rm -rf /tmp/foo");
    unlink($t);

    $copies = array(
      'config/config.php',
      'config/constants.php',
      'config/doctypes.php',
      'config/foreign_chars.php',
      'config/hooks.php',
      'config/migration.php',
      'config/mimes.php',
      'config/profiler.php',
      'config/smileys.php',
      'config/user_agents.php',
      'errors/error_404.php',
      'errors/error_db.php',
      'errors/error_general.php',
      'errors/error_php.php');
    foreach ($copies as $c) {
      $this->zip->add_data('application/app/'.$c, getFile($c));
    }
    $this->zip->add_dir(array(
      'application/app/cache',
      'application/app/core',
      'application/app/helpers',
      'application/app/hooks',
      'application/app/language/english',
      'application/app/libraries',
      'application/app/logs',
      'application/app/third_party',
      'application/test',
      'application/web/res'));

    foreach ($code as $c) {
      $this->zip->add_data('application/'.$c['name'], $c['code']);
    }

    $this->zip->download('application.zip');
  }

  function reset() {
    require APPPATH.'config/database.php'; // NB: I wish CI had a way to access these in a less-hacky way
    $this->load->dbforge();

    $this->dbforge->drop_database($db['default']['database']);
    $this->dbforge->create_database($db['default']['database']);

    $this->db->close();

    $this->load->database();

    $this->dbforge->add_field('id');
    $this->dbforge->add_field(array(
      'name' => array('type' => 'varchar', 'constraint' => 255),
      'role' => array('type' => 'varchar', 'constraint' => 255),
      'sql_text' => array('type' => 'text'),
    ));
    $this->dbforge->create_table('_clctnz_operations');

    $this->dbforge->add_field(array(
      'name' => array('type' => 'varchar', 'constraint' => 255),
      'value' => array('type' => 'text', 'null' => true),
    ));
    $this->dbforge->add_key('name', true);
    $this->dbforge->create_table('_clctnz_application');
    $this->db->query("INSERT INTO _clctnz_application (name) VALUES ('header'), ('footer'), ('style')");

    redirect('/');
  }

  function import() {
    if (!$this->form_validation->run('collectibles_import')) {
      $this->load->view('import');
    }
    else {
      $this->load->view('header');
      $this->output->append_output('<h2>import</h2>');
      $sqls = explode(';', $this->input->post('sql'));
      foreach ($sqls as $sql) {
        $sql = trim($sql);
        if ($sql == "") continue;

        $status = $this->db->simple_query($sql) ? '' : '<br>FAILED';
        $line = substr($sql, 0, strpos($sql, "\n"));
        $this->output->append_output("<code>$line...$status</code>");
      }
      $this->load->view('footer');
    }
  }

  function operation() {
    if (!$this->form_validation->run('operation')) {
      $this->load->view('ops');
    }
    else {
      $this->CollectionApp->saveOperation(
        $this->input->post('name'),
        $this->input->post('role'),
        $this->input->post('sql_text'));
      redirect('/');
    }
  }

  function operation_alter($id) {
    if (!$this->form_validation->run('operation')) {
      $op = $this->CollectionApp->getOperation($id);
      $this->load->view('op', array('op' => $op));
    }
    else {
      $this->CollectionApp->updateOperation(
        $id,
        $this->input->post('name'),
        $this->input->post('role'),
        $this->input->post('sql_text'));
      redirect('/');
    }
  }

  function operation_delete($id) {
    $this->CollectionApp->deleteOperation($id);
    redirect('/');
  }

  function header_footer() {
    if (!$this->form_validation->run('header_footer')) {
      $appData = $this->CollectionApp->getHeaderFooter();
      $this->load->view('application/header_footer', array('header' => $appData->header, 'footer' => $appData->footer));
    }
    else {
      $this->CollectionApp->updateHeaderFooter($this->input->post('header'), $this->input->post('footer'));
      redirect('/');
    }
  }

  function style() {
    if (!$this->form_validation->run('style')) {
      $appData = $this->CollectionApp->getStyle();
      $this->load->view('application/style', array('style' => $appData->style));
    }
    else {
      $this->CollectionApp->updateStyle($this->input->post('style'));
      redirect('/');
    }
  }
}

