<?php
session_start();
$_SESSION = []; // Unset all session variables
session_destroy();
header('Location: login.php');
exit;