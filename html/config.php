<?php return array (
  'application' => 
  array (
    'debug' => false,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'mysql' => 
      array (
        'dbname' => 'pagekit',
        'host' => 'localhost',
        'user' => 'root',
        'prefix' => 'pk_',
        'password' => 'chef2015L',
      ),
    ),
  ),
  'system' => 
  array (
    'secret' => 'iuO0iiPHMzX8uUA5K5t2wY4EXtB4evQnU2cS9MmytlUsCb0TThBDHTOYBvOXDW3J',
  ),
  'system/cache' => 
  array (
    'caches' => 
    array (
      'cache' => 
      array (
        'storage' => 'auto',
      ),
    ),
    'nocache' => false,
  ),
  'system/finder' => 
  array (
    'storage' => '',
  ),
  'debug' => 
  array (
    'enabled' => false,
  ),
);