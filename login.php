<?php

use Ahmedmi\Helpers;



$msg = Helpers::setLoginErrorMsg();

function login($db) {
    try {
        $statement = $db->query("SELECT * FROM users WHERE email = :email AND password = :password AND active = 1", [
            ':email' => $_POST['email'],
            ':password' => sha1($_POST['password'])
        ]);

        $user = $statement->fetchAll(PDO::FETCH_ASSOC);
        Helpers::dump($user[0]);
        if (count($user) > 0) {
            // log him in
            $_SESSION['id'] = $user[0]["id"];
            $_SESSION['email'] = $user[0]["email"];
            $_SESSION['username'] = $user[0]["username"];

            // close db connection
            $db = null;
            $statement = null;

            // redirect to dashboard
            header("Location: /dashboard");
            die(); // die is important
        } else {
            // close db connection
            $db = null;
            $statement = null;
            // set code
            http_response_code(403);
            // set the login error flag
            $_SESSION['loginError'] = true;

            header("Location: /login");
            die(); // die is important
        }
    } catch (PDOException $e) {
        // show an error message
        Helpers::dd($e->getMessage());
    }
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    // try to log him in 
    login($db);
}

// close db
$db = null;


require "./views/login.view.php";
die();
