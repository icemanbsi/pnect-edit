<?php
 return array (
  'name' => 'Pinnect',
  'components' => 
  array (
    'db' => 
    array (
      'connectionString' => 'mysql:host=localhost;dbname=myDatabase',
      'username' => 'myUsername',
      'password' => 'myPassword',
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