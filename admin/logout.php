<?php
/**
 * admin/logout.php
 * destroys the session for the logged in moderator.
 * This also logs the moderator out of the frontend.
 */
session_start();
session_destroy();
header('Location:index.php')
?>
