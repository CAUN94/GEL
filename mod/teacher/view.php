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
 * Prints a particular instance of teacher
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_teacher
 * @copyright  2015 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace teacher with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... teacher instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('teacher', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $teacher  = $DB->get_record('teacher', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $teacher  = $DB->get_record('teacher', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $teacher->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('teacher', $teacher->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_teacher\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $teacher);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/teacher/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($teacher->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('teacher-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($teacher->intro) {
    echo $OUTPUT->box(format_module_intro('teacher', $teacher, $cm->id), 'generalbox mod_introbox', 'teacherintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading('Estado de Sincronizaciones');

$connection = mysqli_connect("localhost", "root", "", "software");
if($_GET['user']=="1")
{
 echo "<h3>Administrador: Estado de Sincronizaciones</h3>";
$query=$connection->query("SELECT * FROM `adminsynchronization` order By `Status` desc");
   echo
      "
      <table class='table'> 
      <tr>
      <td><center>Unidad</center></td>
      <td><center>Periodo</center></td>
      <td><center>Categoria</center></td>
      <td><center>Activo</center></td>
      <td><center>Estado</center></td>
      </tr>";

while ($row = $query->fetch_assoc())
    {
     if($row['Status']=="True")
        {
           ?><tr  align='center'><?php
        }
        else if($row['Status']=="False")
        {
           ?><tr class="warning" align='center'><?php
        }
        else if($row['Status']=="StandBy")
        {
            ?><tr class="info" align='center'><?php
        }
   echo   
  "<td><center>".$row['Unit']."</center></td>
  <td><center>".$row['Period']."</center></td>
  <td><center>".$row['Category']."</center></td>
  <td><center>".$row['Active']."</center></td>
      ";
        if($row['Status']=="True")
        {
           echo " <td><center>Aceptada</center></td>";
        }
        else if($row['Status']=="False")
        {
           echo " <td><center>Rechazada</center></td>";
        }
        else if($row['Status']=="StandBy")
        {
            echo " <td><center>En Espera</center></td>";
        }

      echo"</tr>";

    }
echo "</table>";
}
else if ($_GET['user'] == "2")
{
    echo "<h3>Profesor: Estado de sus Sincronizaciones</h3>";
    $query=$connection->query("SELECT * FROM `adminsynchronization`  order By `Status` desc");
   echo
      "
      <table class='table'> 
      <tr>
      <td><center>Unidad</center></td>
      <td><center>Periodo</center></td>
      <td><center>Categoria</center></td>
      <td><center>Activo</center></td>
      <td><center>Estado</center></td>
      </tr>";

while ($row = $query->fetch_assoc())
    {
     if($row['Status']=="True")
        {
           ?><tr class="success" align='center'><?php
        }
        else if($row['Status']=="False")
        {
           ?><tr class="warning" align='center'><?php
        }
        else if($row['Status']=="StandBy")
        {
            ?><tr class="info" align='center'><?php
        }
   echo   
  "<td><center>".$row['Unit']."</center></td>
  <td><center>".$row['Period']."</center></td>
  <td><center>".$row['Category']."</center></td>
  <td><center>".$row['Active']."</center></td>
      ";
        if($row['Status']=="True")
        {
           echo " <td><center>Aceptada</center></td>";
        }
        else if($row['Status']=="False")
        {
           echo " <td><center>Rechazada</center></td>";
        }
        else if($row['Status']=="StandBy")
        {
            echo " <td><center>En Espera</center></td>";
        }

      echo"</tr>";

    }
echo "</table>";
}
// Finish the page.
echo $OUTPUT->footer();
