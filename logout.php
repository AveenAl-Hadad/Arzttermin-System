
<?php
session_start();
session_unset();
session_destroy();

// Weiterleitung zur Logout-Info-Seite
header("Location: logout-message.php");
exit;
