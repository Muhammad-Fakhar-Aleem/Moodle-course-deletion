<?php
// file: local/scheduledcoursedelete/version.php

defined('MOODLE_INTERNAL') || die();

$plugin->component = 'local_scheduledcoursedelete';
$plugin->version   = 2026050500;
$plugin->requires  = 2024100700;  // Moodle 4.5.0 (this is the fix)
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = '1.0';