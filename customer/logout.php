<?php
session_start();
session_unset();
session_destroy();

header("Location: auth.php"); // ya correct path
exit();
?>