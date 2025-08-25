<?php
defined('MOODLE_INTERNAL') || die();
$capabilities = [
  'mod/s3securepdf:addinstance' => [
    'riskbitmask' => RISK_SPAM | RISK_XSS,
    'captype' => 'write',
    'contextlevel' => CONTEXT_COURSE,
    'archetypes' => ['editingteacher'=>CAP_ALLOW,'manager'=>CAP_ALLOW]
  ],
  'mod/s3securepdf:view' => [
    'captype' => 'read', 'contextlevel' => CONTEXT_MODULE,
    'archetypes' => ['student'=>CAP_ALLOW,'teacher'=>CAP_ALLOW,'editingteacher'=>CAP_ALLOW,'manager'=>CAP_ALLOW]
  ],
  'mod/s3securepdf:download' => [
    'captype' => 'read', 'contextlevel' => CONTEXT_MODULE,
    'archetypes' => ['student'=>CAP_ALLOW,'teacher'=>CAP_ALLOW,'editingteacher'=>CAP_ALLOW,'manager'=>CAP_ALLOW]
  ]
];
