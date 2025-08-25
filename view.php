<?php
require(__DIR__.'/../../config.php');

$id = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id('s3securepdf', $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$context = context_module::instance($cm->id);

$PAGE->set_url(new moodle_url('/mod/s3securepdf/view.php', ['id' => $id]));
require_login($course, true, $cm);
$PAGE->set_context($context);
$PAGE->set_title(format_string($cm->name));
$PAGE->set_heading(format_string($course->fullname));

echo $OUTPUT->header();

// Do NOT echo a manual heading here to avoid duplicate title.
// Optionally show intro/description if enabled.
if (!empty($cm->showdescription)) {
    $instance = $DB->get_record('s3securepdf', ['id' => $cm->instance], '*', MUST_EXIST);
    echo $OUTPUT->box(format_module_intro('s3securepdf', $instance, $cm->id), 'generalbox mod_introbox');
}

// Action button to deliver the PDF (server-side fetch + watermark)
$downloadurl = new moodle_url('/mod/s3securepdf/download.php', ['id' => $cm->id]);
echo $OUTPUT->single_button($downloadurl, get_string('viewpdf', 'mod_s3securepdf'));

echo $OUTPUT->footer();
