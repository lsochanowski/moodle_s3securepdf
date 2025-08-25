<?php
defined('MOODLE_INTERNAL') || die();

$settings = null; // canonical
if ($hassiteconfig && $ADMIN->fulltree) {
  $settings = new admin_settingpage('modsetting_s3securepdf', get_string('pluginname', 'mod_s3securepdf'));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/endpoint', get_string('setting:endpoint','mod_s3securepdf'), '', 'https://s3.eszkola.online', PARAM_URL));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/region', get_string('setting:region','mod_s3securepdf'), '', 'garage', PARAM_TEXT));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/bucket', get_string('setting:bucket','mod_s3securepdf'), '', '', PARAM_TEXT));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/prefix', get_string('setting:prefix','mod_s3securepdf'), '', '', PARAM_TEXT));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/accesskey', get_string('setting:accesskey','mod_s3securepdf'), '', '', PARAM_TEXT));
  $settings->add(new admin_setting_configpasswordunmask('mod_s3securepdf/secretkey', get_string('setting:secretkey','mod_s3securepdf'), '', ''));
  $settings->add(new admin_setting_configcheckbox('mod_s3securepdf/verifytls', get_string('setting:verifytls','mod_s3securepdf'), '', 1));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/connecttimeout', get_string('setting:connecttimeout','mod_s3securepdf'), '', 10, PARAM_INT));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/requesttimeout', get_string('setting:requesttimeout','mod_s3securepdf'), '', 30, PARAM_INT));
  $settings->add(new admin_setting_configcheckbox('mod_s3securepdf/debugs3', get_string('setting:debugs3','mod_s3securepdf'), '', 0));
  $defaulttpl = 'Downloaded by {{fullname}} (id:{{userid}}) on {{timestamp}} UTC — {{course}} — session {{sessionhash}}';
  $settings->add(new admin_setting_configtextarea('mod_s3securepdf/watermarktpl', get_string('setting:watermarktpl','mod_s3securepdf'), '', $defaulttpl));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/fontsize', get_string('setting:fontsize','mod_s3securepdf'), '', 12, PARAM_INT));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/opacity', get_string('setting:opacity','mod_s3securepdf'), '', '0.25', PARAM_RAW));
  $settings->add(new admin_setting_configtext('mod_s3securepdf/angle', get_string('setting:angle','mod_s3securepdf'), '', '45', PARAM_INT));
}
