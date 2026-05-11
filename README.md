Scheduled Course Delete for Moodle 4.5+

local_scheduledcoursedelete is a Moodle local plugin that automatically deletes courses and subcategories from a selected parent category using Moodle Scheduled Tasks (Cron).

The plugin is designed for automated cleanup of large course structures while preventing server overload by deleting only one course or category per cron execution.

Features
Moodle 4.5+ compatible
Scheduled task execution every minute
Deletes courses one-by-one
Automatically removes nested subcategories
Safe gradual deletion process
Prevents server overload
Supports large Moodle installations
Simple admin configuration
How It Works
Administrator enters a Parent Category ID.
Cron runs every minute.
Plugin finds one course inside the category tree.
Deletes the course.
After all courses are removed, empty subcategories are deleted automatically.

Example:

Parent Category
├── Subcategory A
│ ├── Course 1
│ └── Course 2
├── Subcategory B
│ └── Course 3

Execution:

Minute 1 → Delete Course 1
Minute 2 → Delete Course 2
Minute 3 → Delete Course 3
Minute 4 → Delete Subcategory A
Minute 5 → Delete Subcategory B
Installation
Method 1 — Moodle Plugin Installer
Download ZIP package
Go to:

Site administration → Plugins → Install plugins

Upload ZIP file
Complete installation
Method 2 — Manual Installation

Extract plugin into:

/local/scheduledcoursedelete

Then visit:

Site administration → Notifications

to complete installation.

Configuration

Navigate to:

Site administration → Plugins → Local plugins → Scheduled Course Delete

Enter:

Parent Category ID

The plugin will begin processing automatically through cron.

Cron Requirement

Moodle cron must run every minute.

Example Linux cron:

* * * * * /usr/bin/php /path/to/moodle/admin/cli/cron.php >/dev/null
Compatibility
Moodle 4.5+
Tested on Moodle Build 20241025
Safety Notes
Site Home course is never deleted
Only one course/category is processed per execution
Recommended to create database backups before usage
Intended for administrators only
Future Improvements

Planned features may include:

Activity logging
Dry-run mode
Multiple category support
Manual trigger button
Email notifications
Dashboard progress tracking
CLI support
License

GNU GPL v3 or later

Author

Muhammad Fakhar Aleem

Moodle Administrator
LMS & Educational Technology Specialist
Flutter & Web Developer
