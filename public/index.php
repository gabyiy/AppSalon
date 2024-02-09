<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIController;
use Controllers\LoginController;
use Controllers\CitaController;
use MVC\Router;

$router = new Router();

//Initiem sesiunea
//avem un get pentru a ne duce la formular si un post cand trimitem datele din buton
$router->get("/",[LoginController::class,"login"]);
$router->post("/",[LoginController::class,"login"]);

$router->get("/logout",[LoginController::class,"logout"]);

//Recupereaza parola
$router->get("/olvide",[LoginController::class,"olvide"]);
$router->post("/olvide",[LoginController::class,"olvide"]);
$router->get("/recuperar",[LoginController::class,"recuperar"]);
$router->post("/recuperar",[LoginController::class,"recuperar"]);

//Creem conturi

$router->get("/crear-cuenta",[LoginController::class,"crear"]);
$router->post("/crear-cuenta",[LoginController::class,"crear"]);

//Confirmam contu

$router->get("/confirmar-cuenta",[LoginController::class,"confirmar"]);
$router->get("/mensaje",[LoginController::class,"mensaje"]);

//Apis de citas
$router->get("/api/servicios",[APIController::class,"index"]);
//Area privada
$router->get("/cita",[CitaController::class,"index"]);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();