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
 * Prints a particular instance of request
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_request
 * @copyright  2015 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace request with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... request instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('request', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $request  = $DB->get_record('request', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $request  = $DB->get_record('request', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $request->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('request', $request->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_request\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $request);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/request/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($request->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('request-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($request->intro) {
    echo $OUTPUT->box(format_module_intro('request', $request, $cm->id), 'generalbox mod_introbox', 'requestintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading();
$connection = mysqli_connect("localhost", "root", "", "software");

if (!$connection) {
    echo "Error:   MySQL." . PHP_EOL;
    exit;
}
if($_REQUEST['academic'] == null || 
    $_REQUEST['period'] == null ||
     $_REQUEST['category'] == null ||
      $_REQUEST['active'] == null || 
      $_REQUEST['comments'] == null)
{
    echo"<h2><p>Formulario incompleto</p></h2>";
    echo"<a class='btn btn-warning' href='http://localhost/moodle/course/view.php?id=4' role='button'>Volver</a>";
}
else
{
    $insert=$connection->query("INSERT INTO adminsynchronization
    VALUES (null,
    '".$_REQUEST['academic']."',
    '".$_REQUEST['period']."',
    '".$_REQUEST['category']."',
    '".$_REQUEST['active']."',
    '".$_REQUEST['comments']."',
    'StandBy',
    null,
    null)
    ") ;
   
    
    if($insert==1)
    {
     echo "<script type='text/javascript'>window.location.href='http://localhost/moodle/course/view.php?id=2'</script>";

    window.location.replace("http://localhost/moodle/course/view.php?id=2");
    }
    else
    {
        echo"<a class='btn btn-warning' href='http://localhost/moodle/course/view.php?id=4' role='button'>Volver</a>";
    }
}




mysqli_close($enlace);
// Finish the page.
echo $OUTPUT->footer();
