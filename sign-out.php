<?php
session_start();
session_unset();
session_destroy();

header('LOCATION:sign-in.php');

?>