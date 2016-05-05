<?php
/**
 * logout.php
 * Script to destroy users session.
 * If the user is a moderator, this will also log the user out of the administrative area.
 */
session_start();
session_destroy();
header('Location:index.php')
?>
