<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of update
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_update
 * @copyright  2015 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace update with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... update instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('update', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $update  = $DB->get_record('update', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $update  = $DB->get_record('update', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $update->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('update', $update->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_update\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $update);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/update/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($update->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('update-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($update->intro) {
    echo $OUTPUT->box(format_module_intro('update', $update, $cm->id), 'generalbox mod_introbox', 'updateintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading();
$connection = mysqli_connect("localhost", "root", "", "software");
if (!$connection) {
    echo "Error:   MySQL." . PHP_EOL;
    exit;
}
    if($_GET['Status']=="1")
    {
    $update=$connection->query("UPDATE `adminsynchronization` SET `Status`='True' WHERE id=".$_GET['variable']."") ;
    
    if($update!=0)
    {
    echo "<script type='text/javascript'>window.location.href='http://localhost/moodle/mod/adminsynchronization/view.php?id=19&variable=".$_GET['redirect']."' </script>";

    // window.location.replace("http://localhost/moodle/course/view.php?id=2");
    }
    }

    else if($_GET['Status']=="2")
    {
         $update=$connection->query("UPDATE `adminsynchronization` SET `Status`='False' WHERE id=".$_GET['variable']."") ;
      
   
    if($update!=0)
    {
    echo "<script type='text/javascript'>window.location.href='http://localhost/moodle/mod/adminsynchronization/view.php?id=19&variable=".$_GET['redirect']."'</script>";

    // window.location.replace("http://localhost/moodle/course/view.php?id=2");
    }
    }


// Finish the page.
echo $OUTPUT->footer();
