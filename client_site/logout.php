<?php
//Mathew Boullier
//4/3/2026
//Simply destroys our current session to remove our logged out status, and sends us to home_page.php.
session_start();
session_unset();
session_destroy();
header('Location: home_page.php');
exit();
?>