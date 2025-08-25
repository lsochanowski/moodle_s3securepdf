<?php
namespace mod_s3securepdf\task;
defined('MOODLE_INTERNAL') || die();

class purge_cache extends \core\task\scheduled_task {
  public function get_name() { return 'Purge S3 Secure PDF cache'; }
  public function execute() {
    global $CFG;
    $base = $CFG->dataroot.'/local_s3securepdf_cache';
    $ttl = 86400;
    $now = time();
    if (!is_dir($base)) return;
    $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($base, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($it as $file) {
      if ($file->isFile() && ($file->getMTime() + $ttl) < $now) @unlink($file->getPathname());
    }
  }
}
