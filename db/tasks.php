<?php
defined('MOODLE_INTERNAL') || die();
$tasks = [[
  'classname' => 'mod_s3securepdf\task\purge_cache',
  'blocking' => 0,
  'minute' => 'R',
  'hour' => '*',
  'day' => '*',
  'dayofweek' => '*',
  'month' => '*'
]];
