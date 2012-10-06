<?php

$config = array(
  'collectible_define' => array(
    array('field' => 'collectible_name', 'label' => 'collectible name', 'rules' => 'trim|required|max_length[64]|xss_clean'),
  ),

  'collectible_alter' => array(
    array('field' => 'attribute_name[]', 'label' => 'attribute name', 'rules' => 'trim|required|max_length[64]|xss_clean'),
  ),

  'collectible_rename' => array(
    array('field' => 'collectible_name', 'label' => 'collectible name', 'rules' => 'trim|required|max_length[64]|xss_clean'),
  ),

  'item_save' => array(
    array('field' => 'junk', 'label' => '', 'rules' => 'callback_item_save_valid'),
  ),
);

