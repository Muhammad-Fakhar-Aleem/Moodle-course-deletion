<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $settings = new admin_settingpage(
        'local_scheduledcoursedelete',
        get_string('pluginname', 'local_scheduledcoursedelete')
    );

    $settings->add(new admin_setting_configtext(
        'local_scheduledcoursedelete/categoryid',
        get_string('categoryid', 'local_scheduledcoursedelete'),
        get_string('categoryiddesc', 'local_scheduledcoursedelete'),
        '',
        PARAM_INT
    ));

    $ADMIN->add('localplugins', $settings);
}
