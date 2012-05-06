<?php

function getTemplate($path, $replacement = null) {
  if (!$replacement) {
    return htmlspecialchars(file_get_contents(APPPATH.$path));
  }
  else {
    return htmlspecialchars(
      str_replace('$collectible', $replacement,
      str_replace('<?=$collectible?>', $replacement,
        file_get_contents(APPPATH.$path)
      ))
    );
  }
}

class Application extends CI_Controller
{
  function export() {
    $this->load->model('CollectionApp');
    $collectibles = $this->CollectionApp->getTables();
    $code = $this->generateCode($collectibles);
    $this->load->view('export', array('code' => $code));
  }

  private function generateCode($collectibles) {
    $code = array();

    $config = array();
    foreach ($collectibles as $collectible) {
      $config[] = "  '${collectible}_save' => array(array('field' => 'junk', 'label' => '', 'rules' => 'callback_${collectible}_save_valid')),";
    }
    $code[] = array('name' => "app/config/form_validation.php", 'code' => getTemplate('views/templates/form_validation.php', join($config, "\n")));

    foreach ($collectibles as $collectible) {
      $code[] = array('name' => "app/controllers/${collectible}.php", 'code' => getTemplate('views/templates/controller.php', $collectible));
    }

    $code[] = array('name' => 'app/views/header.php', 'code' => getTemplate('views/header.php'));
    $code[] = array('name' => 'app/views/menu.php', 'code' => getTemplate('views/menu.php'));
    $code[] = array('name' => 'app/views/footer.php', 'code' => getTemplate('views/footer.php'));
    foreach ($collectibles as $collectible) {
      $code[] = array('name' => "app/views/${collectible}/all.php", 'code' => getTemplate('views/collectible/all.php', $collectible));
      $code[] = array('name' => "app/views/${collectible}/add.php", 'code' => getTemplate('views/collectible/add.php', $collectible));
      $code[] = array('name' => "app/views/${collectible}/edit.php", 'code' => getTemplate('views/collectible/edit.php', $collectible));
    }

    $sql = array();
    foreach ($collectibles as $collectible) {
      $sql[] = $this->CollectionApp->getSql($collectible);
    }
    $code[] = array('name' => 'sql/setup.sql', 'code' => join($sql, ";\n\n"));
    $code[] = array('name' => 'sql/teardown.sql', 'code' => "DROP TABLE IF EXISTS\n  " . join($collectibles, ",\n  ") . ';');

    return $code;
  }
}

