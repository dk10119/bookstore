<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            if ($username == "" || $password == "") {
                $error_msg = "Please enter Username and Password!";
            } else {
                $json = file_get_contents("assets/user.json");
                $users = json_decode($json, true);
                $id = array_search($username, array_column($users, "username"));
                if ($id === FALSE) {
                    $error_msg = "Username or Password not match";
                } elseif ($password !== $users[$id]["password"]) {
                    $error_msg = "Username or Password not match";
                } elseif ($users[$id]["is_admin"] === true) {
                    $error_msg = "Login succesfully!";
                    $_SESSION["username"] = $username;
                    $_SESSION["is_admin"] = "true";
                    header("Location: admin.php");
                }
                //  elseif (!$users[$id]["is_admin"]) {
                //     $error_msg = "Login succesfully!";
                //     session_start();
                //     $_SESSION["username"] = $username;
                //     header("Location: booksite.php");
                // }
                // this block is to redirect non admin member
            }
        }
    }

    if (isset($_GET["logout"])) {
        session_unset();
        session_destroy();
        $error_msg = "Successfully logged out!";
    } 

    if (isset($_SESSION["is_admin"])) header("Location: admin.php");
    // elseif (isset($_SESSION["username"])) {
    //     header("Location: booksite.php");
    // }
    // redirect non admin member

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorite Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="booksite.css">
</head>
<body>
    <div id="container">
        <header>
            <h1>Your Favorite Books</h1>
        </header>
        <nav id="main-navi">
            <ul>
                <li><a href="booksite.php">Home</a></li>
                <li><a href="booksite.php?category=adventure">Adventure</a></li>
                <li><a href="booksite.php?category=classic">Classic Literature</a></li>
                <li><a href="booksite.php?category=coming-of-age">Coming-of-age</a></li>
                <li><a href="booksite.php?category=fantasy">Fantasy</a></li>
                <li><a href="booksite.php?category=historical">Historical Fiction</a></li>
                <li><a href="booksite.php?category=horror">Horror</a></li>
                <li><a href="booksite.php?category=mystery">Mystery</a></li>
                <li><a href="booksite.php?category=romance">Romance</a></li>
                <li><a href="booksite.php?category=scifi">Science Fiction</a></li>
            </ul>
        </nav>
        <main>
            <form action="login.php" method="post">
                <p>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username">
                </p>
                <p>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </p>
                <p><input type="submit" name="login" value="Log in"></p>
                <p style="color: red"><?php echo @$error_msg ?></p>
            </form>
        </main>
    </div>    
</body>
</html>