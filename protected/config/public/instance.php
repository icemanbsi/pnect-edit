<?php
 date_default_timezone_set('Asia/Jakarta');
 return array (
  'name' => 'Pinnect',
  'components' => 
  array (
    'db' => 
    array (
      'connectionString' => 'mysql:host=localhost;dbname=pinnect112',
      'username' => 'root',
      'password' => '',
      'tablePrefix' => 'pnct_',
    ),
    'urlManager' => 
    array (
      'urlFormat' => 'path',
      'showScriptName' => false,
      'rules' => 
      array (
        'page/<view>' => 'base/page',
      ),
    ),
  ),
  'theme' => 'classic',
);