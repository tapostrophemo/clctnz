<?php

$config = array(
  'collectible_define' => array(
    array('field' => 'collectible_name', 'label' => 'collectible name', 'rules' => 'trim|required|max_length[64]|xss_clean'),
  ),

  'collectible_alter' => array(
    array('field' => 'collectible_name', 'label' => 'collectible name', 'rules' => 'trim|required|max_length[64]|xss_clean'),
  ),

  'collectible_save' => array(
    array('field' => 'junk', 'label' => '', 'rules' => 'callback_collectible_save_valid'),
  ),
);

