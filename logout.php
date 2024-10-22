<?php
session_start();
session_destroy();
header('Location: login.php'); // Redirect back to login selection
exit();
?>
