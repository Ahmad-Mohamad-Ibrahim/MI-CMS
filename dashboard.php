<?php

use Ahmedmi\Helpers;

Helpers::dump($_SESSION["id"]);
Helpers::dump($_SESSION["email"]);
Helpers::dump($_SESSION["username"]);

// close db connection
$db = null;

?>