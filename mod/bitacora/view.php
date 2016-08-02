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
 * Prints a particular instance of bitacora
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_bitacora
 * @copyright  2015 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace bitacora with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... bitacora instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('bitacora', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $bitacora  = $DB->get_record('bitacora', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $bitacora  = $DB->get_record('bitacora', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $bitacora->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('bitacora', $bitacora->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_bitacora\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $bitacora);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/bitacora/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($bitacora->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('bitacora-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($bitacora->intro) {
    echo $OUTPUT->box(format_module_intro('bitacora', $bitacora, $cm->id), 'generalbox mod_introbox', 'bitacoraintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading('Ver Proyectos');

$connection = mysqli_connect("localhost", "root", "", "Proyectos");
echo "<hr>";

if (isset($_GET['data']))
{

    $insert=$connection->query("INSERT INTO 
        `anotaciones`(`idanotaciones`, `Data`, `Porcentaje`, `proyectos_idproyectos`) 
        VALUES (null,'".$_GET['data']."',".$_GET['porcentaje'].",".$_GET['variable'].")");
    $update=$connection->query("UPDATE `proyectos` SET `Nombre`='".$_GET['nombre']."' WHERE idproyectos=".$_GET['variable']."");

    if($insert==1 or $update==TRUE)
    {
   echo "<script type='text/javascript'>window.location.href='http://localhost/moodle/mod/bitacora/view.php?id=28&variable=".$_GET['variable']."'</script>";

    window.location.replace("http://localhost/moodle/mod/bitacora/view.php?id=28&variable=".$_GET['variable']."");
    }
}

elseif(isset($_GET['variable']))
{
$query=$connection->query("SELECT * FROM `proyectos`,`anotaciones` where idproyectos=proyectos_idproyectos and idproyectos=".$_GET['variable']."");


$resultado = $connection->query("SELECT * FROM `proyectos` where idproyectos=".$_GET['variable']."");
$row = $resultado->fetch_assoc();
 echo"   <form action='http://localhost/moodle/mod/bitacora/view.php?id=28&variable=".$row['idproyectos']."' method='GET'>";


echo "<br>
    <input type='text' class='form-control' name='nombre' id='porcentaje' value='".$row['Nombre']."'>";





$query=$connection->query("SELECT * FROM `proyectos`,`anotaciones` where idproyectos=proyectos_idproyectos and idproyectos=".$_GET['variable']."");

    while ($row = $query->fetch_assoc())
    {
      echo 
      "<table  '>
      <tr>
      <td> 
      <li><h3>Nombre del proyecto ". $row['Data']." avanze de un ". $row['Porcentaje']."%</h3></li>
      <td/>
      <td>

      </td>
      </tr>
      <tr>

      </table><br>";
    }

    echo 
    "
    <form action='http://localhost/moodle/mod/bitacora/view.php?id=28&variable=".$row['idproyectos']."' method='GET'>
    <input type='hidden' name='id' value=28>
    <input type='hidden' name='variable' value=".$_GET['variable'].">
  <div class='form-group'>
    <label for='exampleInputEmail1'><h3>Nuevos Avanzes</h3></label>
    <input type='text' class='form-control' name='data' id='data' placeholder='Nuevos Avances'>
  </div>
  <div class='form-group'>
    <label for='exampleInputPassword1'>Avance en porcentaje %</label>
    <input type='number' class='form-control' name='porcentaje' id='porcentaje' placeholder='0%'>
  </div>

  <button type='submit'  class='btn btn-default'>Cargar</button>
</form>
    ";

}

elseif(isset($_GET['proyecto']))
{
    
    $insert=$connection->query("INSERT INTO `proyectos`(`idproyectos`, `Nombre`) VALUES (null,'".$_GET['proyect']."')");

    if($insert==1 )
    {
   echo "<script type='text/javascript'>window.location.href='http://localhost/moodle/mod/bitacora/view.php?id=28'</script>";

    window.location.replace("http://localhost/moodle/mod/bitacora/view.php?id=28");
    }
}


else
{

$query=$connection->query("SELECT * FROM `proyectos`");
    while ($row = $query->fetch_assoc())
    {
      echo 
      "<table  '>
      <tr>
      <td> <li><h3><a href='http://localhost/moodle/mod/bitacora/view.php?id=28&variable=".$row['idproyectos']."'>". $row['Nombre']."</a></h3></li><td/>
      </tr>
      <tr>

      </table><br>";
       
    }
      echo 
    "
    <form action='http://localhost/moodle/mod/bitacora/view.php?id=28' method='GET'>
    <input type='hidden' name='id' value=28>
    <input type='hidden' name='proyecto' value=1>
  <div class='form-group'>
    <label for='exampleInputEmail1'><h3>Nuevos Proyecto</h3></label>
    <input type='text' class='form-control' name='proyect' id='data' placeholder='Nombre'>
  </div>


  <button type='submit'  class='btn btn-default'>Cargar</button>
</form>
    ";

}
// Finish the page.
echo $OUTPUT->footer();
