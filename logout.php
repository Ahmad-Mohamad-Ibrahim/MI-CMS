<?php
echo "logout";
session_destroy();
$_SESSION = array();
header("Location: /login");
die(); // exit closes the connection (don't know which is better)