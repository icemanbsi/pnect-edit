<?php
return array (
  'guest' => 
  array (
    'type' => 2,
    'description' => 'Guest',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'administrator' => 
  array (
    'type' => 2,
    'description' => 'Administrator',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
      1 => 'user',
      2 => 'board.edit',
      3 => 'post.edit',
    ),
  ),
  'user' => 
  array (
    'type' => 2,
    'description' => 'User',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
      1 => 'board.editor',
      2 => 'post.editor',
    ),
  ),
  'unverified' => 
  array (
    'type' => 2,
    'description' => 'Unverified',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
    ),
  ),
  'banned' => 
  array (
    'type' => 2,
    'description' => 'Banned',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
    ),
  ),
  'unapproved' => 
  array (
    'type' => 2,
    'description' => 'Unapproved',
    'bizRule' => NULL,
    'data' => NULL,
    'children' => 
    array (
      0 => 'guest',
    ),
  ),
  'board.editor' => 
  array (
    'type' => 1,
    'description' => NULL,
    'bizRule' => 'return $params->userId == app()->user->id;',
    'data' => NULL,
    'children' => 
    array (
      0 => 'board.edit',
    ),
  ),
  'board.edit' => 
  array (
    'type' => 1,
    'description' => 'Board edit access',
    'bizRule' => NULL,
    'data' => NULL,
  ),
  'post.editor' => 
  array (
    'type' => 1,
    'description' => NULL,
    'bizRule' => 'return $params->userId == app()->user->id;',
    'data' => NULL,
    'children' => 
    array (
      0 => 'post.edit',
    ),
  ),
  'post.edit' => 
  array (
    'type' => 1,
    'description' => 'Post edit access',
    'bizRule' => NULL,
    'data' => NULL,
  ),
);
