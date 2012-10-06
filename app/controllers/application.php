<?php

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
  function export() {
    $this->load->model('CollectionApp');
    $collectibles = $this->CollectionApp->getTables();
    $code = $this->generateCode($collectibles);
    if ($this->input->post('to_file') == true) {
      $this->downloadAsZip($code);
    }
    else {
      $this->load->view('export', array('code' => $code));
    }
  }

  private function generateCode($collectibles) {
    $code = array();

    $config = array();
    foreach ($collectibles as $collectible) {
      $config[] = "  '${collectible}_save' => array(array('field' => 'junk', 'label' => '', 'rules' => 'callback_${collectible}_save_valid')),";
    }
    $code[] = array('name' => "app/config/form_validation.php", 'code' => getTemplate('views/templates/form_validation.php', join($config, "\n")));
    $code[] = array('name' => 'app/config/routes.php', 'code' => getTemplate('views/templates/routes.php'));

    foreach ($collectibles as $collectible) {
      $code[] = array('name' => "app/controllers/${collectible}.php", 'code' => getTemplate('views/templates/controller.php', $collectible));
    }
    $code[] = array('name' => 'app/controllers/site.php', 'code' => getTemplate('views/templates/site_controller.php'));

    $code[] = array('name' => 'app/views/header.php', 'code' => getTemplate('views/header.php'));
    $code[] = array(
      'name' => 'app/views/menu.php',
      'code' => "<?php \$this->view(\"header\"); ?>\n" .
                $this->load->view('templates/menu', array('collectibles' => $collectibles), true) .
                '<?php $this->view("footer"); ?>');
    $code[] = array('name' => 'app/views/footer.php', 'code' => getTemplate('views/footer.php'));
    foreach ($collectibles as $collectible) {
      $code[] = array('name' => "app/views/${collectible}/all.php", 'code' => getTemplate('views/items/all.php', $collectible));
      $code[] = array('name' => "app/views/${collectible}/add.php", 'code' => getTemplate('views/items/add.php', $collectible));
      $code[] = array('name' => "app/views/${collectible}/edit.php", 'code' => getTemplate('views/items/edit.php', $collectible));
    }

    $sql = array();
    foreach ($collectibles as $collectible) {
      $sql[] = $this->CollectionApp->getSql($collectible);
    }
    $code[] = array('name' => 'sql/setup.sql', 'code' => join($sql, ";\n\n") . ';');
    $code[] = array('name' => 'sql/teardown.sql', 'code' => "DROP TABLE IF EXISTS\n  " . join($collectibles, ",\n  ") . ';');

    $code[] = array('name' => 'web/index.php', 'code' => getTemplate('../web/index.php'));
    $code[] = array('name' => 'web/.htaccess', 'code' => getTemplate('../web/.htaccess'));

    return $code;
  }

  private function downloadAsZip($code) {
    $this->load->library('zip');
    foreach ($code as $c) {
      $this->zip->add_data('application/'.$c['name'], $c['code']);
    }
    $this->zip->add_dir(array(
      'application/app/cache',
      'application/app/core',
      'application/app/errors',
      'application/app/helpers',
      'application/app/hooks',
      'application/app/language/english',
      'application/app/libraries',
      'application/app/logs',
      'application/app/models',
      'application/app/third_party',
      'application/lib',
      'application/test',
      'application/web/res'));
    $this->zip->download('application.zip');
  }
}

