<?php
namespace mod_s3securepdf\event;
defined('MOODLE_INTERNAL') || die();

class file_downloaded extends \core\event\base {
  protected function init() {
    $this->data['crud'] = 'r';
    $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    $this->data['objecttable'] = 's3securepdf';
  }
  public static function get_name() {
    return get_string('event:file_downloaded', 'mod_s3securepdf');
  }
  public function get_description() {
    return "User {$this->userid} downloaded S3 Secure PDF instance {$this->objectid}.";
  }
  public function get_url() {
    return new \moodle_url('/mod/s3securepdf/view.php', ['id'=>$this->contextinstanceid]);
  }
}
