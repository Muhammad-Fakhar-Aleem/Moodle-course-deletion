<?php
// file: local/scheduledcoursedelete/classes/task/delete_courses_task.php

namespace local_scheduledcoursedelete\task;

use core_course_category;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/lib.php');

class delete_courses_task extends \core\task\scheduled_task {

    public function get_name() {
        return get_string('taskname', 'local_scheduledcoursedelete');
    }

    public function execute() {
        global $DB;

        $parentcategoryid = get_config('local_scheduledcoursedelete', 'categoryid');

        if (empty($parentcategoryid)) {
            mtrace('No category ID configured.');
            return;
        }

        $parentcategory = $DB->get_record('course_categories', ['id' => $parentcategoryid]);

        if (!$parentcategory) {
            mtrace('Parent category not found.');
            return;
        }

        // Step 1: Delete ALL courses in parent and all subcategories
        $categories = $this->get_all_subcategories($parentcategoryid);
        $categories[] = $parentcategoryid; // include parent itself

        foreach ($categories as $categoryid) {
            // Get ALL courses in this category (no limit)
            $courses = $DB->get_records('course', ['category' => $categoryid], 'id ASC');

            foreach ($courses as $course) {
                if ($course->id == SITEID) {
                    continue;
                }

                mtrace('Deleting course: ' . $course->fullname . ' (ID: ' . $course->id . ')');
                delete_course($course, false);
            }
        }

        // Step 2: Delete all empty subcategories (deepest first)
        rsort($categories); // reverse order to delete children before parents

        foreach ($categories as $categoryid) {
            if ($categoryid == $parentcategoryid) {
                continue; // keep the parent category itself if configured
            }

            $coursecount = $DB->count_records('course', ['category' => $categoryid]);
            $subcategorycount = $DB->count_records('course_categories', ['parent' => $categoryid]);

            if ($coursecount == 0 && $subcategorycount == 0) {
                $category = core_course_category::get($categoryid);
                mtrace('Deleting subcategory ID: ' . $categoryid);
                $category->delete_full(false);
            }
        }

        mtrace('All courses and subcategories deleted.');
    }

    private function get_all_subcategories($parentid) {
        global $DB;

        $allcategories = [];
        $subcategories = $DB->get_records('course_categories', ['parent' => $parentid]);

        foreach ($subcategories as $subcategory) {
            $allcategories[] = $subcategory->id;
            $childcategories = $this->get_all_subcategories($subcategory->id);
            if (!empty($childcategories)) {
                $allcategories = array_merge($allcategories, $childcategories);
            }
        }

        return $allcategories;
    }
}