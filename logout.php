<?php
session_start();

session_destroy();

header("Location: PharmaCare Homepage/login.html");
exit;
?>
