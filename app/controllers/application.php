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

    $sql = '';
    $code = array(
      array('name' => 'app/views/header.php', 'code' => getTemplate('views/header.php')),
      array('name' => 'app/views/menu.php', 'code' => getTemplate('views/menu.php')),
      array('name' => 'app/views/footer.php', 'code' => getTemplate('views/footer.php')),
    );
    foreach ($collectibles as $collectible) {
      $sql .= "\n" . $this->CollectionApp->getSql($collectible) . ";\n";
      $code[] = array('name' => "app/views/${collectible}/all.php", 'code' => getTemplate('views/collectible/all.php', $collectible));
      $code[] = array('name' => "app/views/${collectible}/add.php", 'code' => getTemplate('views/collectible/add.php', $collectible));
      $code[] = array('name' => "app/views/${collectible}/edit.php", 'code' => getTemplate('views/collectible/edit.php', $collectible));
    }
    foreach ($collectibles as $collectible) {
      $code[] = array('name' => "app/controllers/${collectible}.php", 'code' => getTemplate('views/templates/controller.php', $collectible));
    }

    $this->load->view('export', array('sql' => $sql, 'code' => $code));
  }
}

