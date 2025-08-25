<?php
require('../../config.php');
require_once($CFG->dirroot.'/mod/s3securepdf/lib.php');

use mod_s3securepdf\local\token as tok;

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('s3securepdf', $id, 0, false, MUST_EXIST);
$context = context_module::instance($cm->id);
$course = get_course($cm->course);
$instance = $DB->get_record('s3securepdf', ['id'=>$cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm);
require_capability('mod/s3securepdf:view', $context);

$PAGE->set_url('/mod/s3securepdf/view.php', ['id'=>$id]);
$PAGE->set_title(format_string($instance->name));
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(format_string($instance->name), 2);

if (!empty($instance->intro)) {
    echo $OUTPUT->box(format_module_intro('s3securepdf', $instance, $cm->id), 'generalbox mod_introbox', 's3securepdfintro');
}

$token = tok::make($USER->id, $cm->id);
$dlurl = new moodle_url('/mod/s3securepdf/download.php', ['id'=>$id, 'token'=>$token]);
echo html_writer::div(html_writer::link($dlurl, get_string('download', 'mod_s3securepdf'), ['class'=>'btn btn-primary']));

echo $OUTPUT->footer();
