<?php

session_start();

session_unset(); // unset the sessions variables

session_destroy(); // kill the session

setcookie(session_name(), '', time() - 3600, '/');

// direct to log in page after loging out
header("Location: ../log in system/php/login-interface.php");
exit();

?>

