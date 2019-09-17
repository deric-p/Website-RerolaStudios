<?php

session_start();
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

echo "Welcome, ".$username."<a href'logout.php'> Logout</a>'"

?>