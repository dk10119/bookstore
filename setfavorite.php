<?php

if (isset($_GET["add"])) {
    if (isset($_COOKIE["favorites"])) {
        setcookie("favorites", $_COOKIE['favorites'] . "," . $_GET["add"], time()+24*60*60);
    } else setcookie("favorites", $_GET["add"], time()+24*60*60);
    header("Location:" . $_SERVER["HTTP_REFERER"]);
} elseif (isset($_GET["remove"])) {
    setcookie("favorites", implode(",", array_diff(explode(",", $_COOKIE["favorites"]), [$_GET["remove"]])), time()+24*60*60);
    header("Location:" . $_SERVER["HTTP_REFERER"]);
} else header("Location: booksite.php");