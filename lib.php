<?php
defined('MOODLE_INTERNAL') || die();

function s3securepdf_supports($feature) {
  switch ($feature) {
    case FEATURE_MOD_INTRO: return true;
    case FEATURE_SHOW_DESCRIPTION: return true;
    default: return null;
  }
}

function s3securepdf_add_instance($data, $mform = null) {
  global $DB;
  $r = new stdClass();
  $r->course = $data->course;
  $r->name = trim($data->name);
  $r->intro = $data->intro ?? '';
  $r->introformat = $data->introformat ?? 1;
  $r->objectkey = $data->objectkey;
  $r->watermarktpl = $data->watermarktpl ?? null;
  $r->timemodified = time();
  return $DB->insert_record('s3securepdf', $r);
}

function s3securepdf_update_instance($data, $mform = null) {
  global $DB;
  $r = $DB->get_record('s3securepdf', ['id'=>$data->instance], '*', MUST_EXIST);
  $r->name = trim($data->name);
  $r->intro = $data->intro ?? '';
  $r->introformat = $data->introformat ?? 1;
  $r->objectkey = $data->objectkey;
  $r->watermarktpl = $data->watermarktpl ?? null;
  $r->timemodified = time();
  return $DB->update_record('s3securepdf', $r);
}

function s3securepdf_delete_instance($id) {
  global $DB;
  if (!$DB->record_exists('s3securepdf', ['id'=>$id])) return false;
  $DB->delete_records('s3securepdf', ['id'=>$id]);
  return true;
}
