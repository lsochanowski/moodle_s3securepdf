<?php
require('../../config.php');
require_once($CFG->dirroot.'/course/lib.php');

$id = required_param('id', PARAM_INT);
$course = get_course($id);
require_login($course);

$PAGE->set_pagelayout('incourse');
$PAGE->set_url('/mod/s3securepdf/index.php', ['id'=>$id]);
$PAGE->set_title(get_string('modulenameplural', 'mod_s3securepdf'));
$PAGE->set_heading($course->fullname);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('modulenameplural', 'mod_s3securepdf'), 2);

if (!$cms = get_coursemodules_in_course('s3securepdf', $course->id)) {
    echo $OUTPUT->notification(get_string('none'), 'warning');
    echo $OUTPUT->footer();
    exit;
}

$table = new html_table();
$table->head = [get_string('name'), get_string('intro', 'mod_s3securepdf')];
foreach ($cms as $cm) {
    $instance = $DB->get_record('s3securepdf', ['id'=>$cm->instance], '*', MUST_EXIST);
    $link = html_writer::link(new moodle_url('/mod/s3securepdf/view.php', ['id'=>$cm->id]), format_string($instance->name));
    $table->data[] = [$link, format_text($instance->intro, $instance->introformat)];
}
echo html_writer::table($table);
echo $OUTPUT->footer();
