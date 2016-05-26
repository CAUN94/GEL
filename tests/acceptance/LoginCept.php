<?php 
date_default_timezone_set('America/Santiago');
$I = new AcceptanceTester($scenario);
$I->wantTo('Login in as a Admin user');
$I->amOnPage('http://localhost/moodle/login/index.php');
$I->fillField('username','caun94');
$I->fillField('password','3378-WsS');
$I->click('loginbtn');
$I->see('Cristóbal');

$J = new AcceptanceTester($scenario);
$J->wantTo('See link in Solicitudes de Sincronizacion');
$J->amOnPage('http://localhost/moodle/course/view.php?id=5');
$J->see('Omega');
$J->see('Webcursos');
$J->see('Asistencia de Pregrado');

$K = new AcceptanceTester($scenario);
$K->wantTo('See Link in admin Omega');
$K->amOnPage('http://localhost/moodle/course/view.php?id=3');
$K->see('Solicitudes de Sincronización');
$K->see('Crear Sincronización');
$K->see('Estado de Sincronización');

$L = new AcceptanceTester($scenario);
$L->wantTo('Check Links');
$L->amOnPage('http://localhost/moodle/course/view.php?id=5');
$L->click(['link' => 'Omega']);

// $M = new AcceptanceTester($scenario);
// $M->wantTo('Check Links');
// $M->amOnPage('http://localhost/moodle/course/view.php?id=3');
// $M->click(['link' => 'Solicitudes de Sincronización']);