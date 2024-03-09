<?php
if (isset($_GET["add"])) setcookie("favorites", implode(",", [...explode(",", $_COOKIE["favorites"]), $_GET["add"]]), time()+24*60*60);
//explode the favorites cookie into an array, spread it, form another array with the GET parameter, implode it into a string and set it as cookie.
if (isset($_GET["remove"])) setcookie("favorites", implode(",", array_diff(explode(",", $_COOKIE["favorites"]), [$_GET["remove"]])), time()+24*60*60);
//explode the cookie into an array, compare the difference with GET parameter, implode it into a string, and set the string it as cookie.
header("Location: booksite.php");