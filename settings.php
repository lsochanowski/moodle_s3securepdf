<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('mod_s3securepdf', get_string('pluginname', 'mod_s3securepdf'));

    $settings->add(new admin_setting_configcheckbox(
        'mod_s3securepdf/usesignedurls',
        get_string('usesignedurls', 'mod_s3securepdf'),
        get_string('usesignedurls_desc', 'mod_s3securepdf'),
        0
    ));

    $settings->add(new admin_setting_configtext(
        'mod_s3securepdf/s3_endpoint',
        get_string('s3_endpoint', 'mod_s3securepdf'),
        get_string('s3_endpoint_desc', 'mod_s3securepdf'),
        '', PARAM_URL
    ));
    $settings->add(new admin_setting_configtext(
        'mod_s3securepdf/s3_region',
        get_string('s3_region', 'mod_s3securepdf'),
        '', 'us-east-1', PARAM_ALPHANUMEXT
    ));
    $settings->add(new admin_setting_configtext(
        'mod_s3securepdf/s3_bucket',
        get_string('s3_bucket', 'mod_s3securepdf'),
        '', '', PARAM_ALPHANUMEXT
    ));
    $settings->add(new admin_setting_configpasswordunmask(
        'mod_s3securepdf/s3_accesskey',
        get_string('s3_accesskey', 'mod_s3securepdf'),
        '', ''
    ));
    $settings->add(new admin_setting_configpasswordunmask(
        'mod_s3securepdf/s3_secretkey',
        get_string('s3_secretkey', 'mod_s3securepdf'),
        '', ''
    ));

    $ADMIN->add('modules', $settings);
}
