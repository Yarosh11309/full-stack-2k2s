<?php

declare(strict_types=1);

use app\controllers\PresentationController;
use app\controllers\NoteController;
use app\controllers\AuthController;
use app\core\Application;
use app\core\ConfigParser;

const PROJECT_ROOT = __DIR__ . "/../";

require PROJECT_ROOT . "vendor/autoload.php";

ConfigParser::load();
if ($_ENV["APP_ENV"] === "dev") {
    error_reporting(E_ALL);
    ini_set("display_errors", "1");
    ini_set("log_errors", "1");
    ini_set("error_log", sprintf("%sruntime/%s", PROJECT_ROOT, $_ENV["PHP_LOG"]));
}





$application = new Application();

$router = $application->getRouter();

$presentation = new PresentationController();
$notes = new NoteController();
$auth = new AuthController();

$router->setGetRoute("/", [$notes, "index"]);
$router->setGetRoute("/notes", [$notes, "index"]);
$router->setGetRoute("/notes/create", [$notes, "createView"]);
$router->setPostRoute("/notes/create", [$notes, "create"]);
$router->setGetRoute("/notes/edit", [$notes, "editView"]);
$router->setPostRoute("/notes/edit", [$notes, "edit"]);
$router->setGetRoute("/notes/delete", [$notes, "delete"]);

$router->setGetRoute("/login", [$auth, "loginView"]);
$router->setPostRoute("/login", [$auth, "login"]);
$router->setGetRoute("/register", [$auth, "registerView"]);
$router->setPostRoute("/register", [$auth, "register"]);
$router->setGetRoute("/logout", [$auth, "logout"]);

$router->setGetRoute("/presentation", [$presentation, "getView"]);
$router->setPostRoute("/handle", [$presentation, "handleView"]);
$router->setGetRoute("/error", "");

ob_start();
$application->run();
ob_flush();

