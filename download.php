<?php
require('../../config.php');
require_once($CFG->libdir.'/filelib.php');

use mod_s3securepdf\local\s3storage;
use mod_s3securepdf\local\watermark;
use mod_s3securepdf\local\token as tok;

$id = required_param('id', PARAM_INT);
$token = required_param('token', PARAM_RAW);

$cm = get_coursemodule_from_id('s3securepdf', $id, 0, false, MUST_EXIST);
$context = context_module::instance($cm->id);
$course = get_course($cm->course);
$instance = $DB->get_record('s3securepdf', ['id'=>$cm->instance], '*', MUST_EXIST);

require_login($course, false, $cm);
require_capability('mod/s3securepdf:download', $context);

if (!tok::verify($token, $USER->id, $cm->id)) {
    throw new moodle_exception('invalidtoken', 'mod_s3securepdf');
}

$bucket = get_config('mod_s3securepdf', 'bucket');
$key = $instance->objectkey;
$tpl = $instance->watermarktpl ?? get_config('mod_s3securepdf','watermarktpl');

$hash = sha1($key.'|'.$USER->id.'|'.$tpl);
$cachedir = make_writable_directory($CFG->dataroot.'/local_s3securepdf_cache/'.$cm->id.'/'.$USER->id);
$cachefile = $cachedir.'/'.$hash.'.pdf';
$cacheseconds = 86400;

$expired = !file_exists($cachefile) || (time() - filemtime($cachefile) > $cacheseconds);

if ($expired) {
    $tmpsrc = tempnam($CFG->tempdir, 's3src');
    $tmpdst = tempnam($CFG->tempdir, 's3dst');
    s3storage::download_to($bucket, $key, $tmpsrc);

    $ctx = [
      'fullname' => fullname($USER),
      'username' => $USER->username,
      'userid'   => $USER->id,
      'timestamp'=> gmdate('Y-m-d H:i:s'),
      'course'   => $course->fullname,
      'sessionhash' => substr(sha1(session_id()), 0, 12)
    ];
    $text = watermark::build_text($tpl, $ctx);
    watermark::apply($tmpsrc, $tmpdst, $text);
    @rename($tmpdst, $cachefile);
    @unlink($tmpsrc);
}

$filename = basename($key);
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'.rawurlencode($filename).'"');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
readfile($cachefile);

$event = \mod_s3securepdf\event\file_downloaded::create([
  'objectid' => $instance->id,
  'context' => $context,
  'relateduserid' => $USER->id,
  'other' => ['key'=>$key]
]);
$event->trigger();
exit;
