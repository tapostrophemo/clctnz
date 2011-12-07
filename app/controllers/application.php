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

    $sql = '';
    $code = array(
      array('name' => 'header.php', 'code' => getTemplate('views/header.php')),
      array('name' => 'menu.php', 'code' => getTemplate('views/menu.php')),
      array('name' => 'footer.php', 'code' => getTemplate('views/footer.php')),
    );
    foreach ($this->CollectionApp->getTables() as $collectible) {
      $sql .= "\n" . $this->CollectionApp->getSql($collectible) . ";\n";
      $code[] = array('name' => "${collectible}_all.php", 'code' => getTemplate('views/collectible/all.php', $collectible));
      $code[] = array('name' => "${collectible}_add.php", 'code' => getTemplate('views/collectible/add.php', $collectible));
      $code[] = array('name' => "${collectible}_edit.php", 'code' => getTemplate('views/collectible/edit.php', $collectible));
    }

    $this->load->view('export', array('sql' => $sql, 'code' => $code));
  }
}

