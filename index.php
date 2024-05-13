<?php

session_start();

require "./vendor/autoload.php";

use Ahmedmi\Database;

$env = parse_ini_file('.env');

$username = $env["DB_USERNAME"];
$host = $env["DB_HOST"];
$dbname = $env["DB_NAME"];
$dbport = $env["DB_PORT"];
$secret = $env["DB_SECRET"];

$db = new Database("mysql:host={$host};port={$dbport};user={$username};password={$secret};dbname={$dbname};charset=utf8mb4");


// check if user is logged in 
$isUserLoggedIn = isset($_SESSION['id']);

require "partials/header.php";

// content
// router loading things here or whatever



// router init
$router = new \Ahmedmi\Router();

$router->get("/dashboard", function () use($isUserLoggedIn) {
    // some checking for auth
    // this really should happen with a middleware
    if ($isUserLoggedIn) {
        require "dashboard.php";
    } else {
        header('Location: /login');
        die();
    }
});

$router->get("/logout", function () {
    require "logout.php";
});

$router->post("/login", function () use($db) {
    require "login.php";
});

// not sure using use here is the best idea
$router->get("/login", function () use($db) {
    require "login.php";
});

$router->run();


require "partials/footer.php";
