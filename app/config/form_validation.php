<?php

$config = array(
  'collectible_define' => array(
    array('field' => 'collectible_name', 'label' => 'collectible name', 'rules' => 'trim|required|max_length[64]|xss_clean'),
  ),
);

