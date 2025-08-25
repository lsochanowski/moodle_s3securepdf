<?php
require_once($CFG->dirroot.'/course/moodleform_mod.php');

class mod_s3securepdf_mod_form extends moodleform_mod {
  public function definition() {
    $mform = $this->_form;

    $mform->addElement('text', 'name', get_string('name'));
    $mform->addRule('name', null, 'required', null, 'client');
    $mform->setType('name', PARAM_TEXT);

    $this->standard_intro_elements();

    $mform->addElement('text', 'objectkey', get_string('objectkey','mod_s3securepdf'));
    $mform->addRule('objectkey', null, 'required', null, 'client');
    $mform->setType('objectkey', PARAM_RAW_TRIMMED);
    $mform->addHelpButton('objectkey', 'objectkey', 'mod_s3securepdf');

    $mform->addElement('text', 'watermarktpl', get_string('watermarktpl', 'mod_s3securepdf'));
    $mform->setType('watermarktpl', PARAM_RAW);

    $this->standard_coursemodule_elements();
    $this->add_action_buttons();
  }
}
