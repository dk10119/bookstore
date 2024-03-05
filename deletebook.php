<?php
    session_start();
    if (!isset($_SESSION["is_admin"])) header("Location: login.php");

    $json = file_get_contents("assets/books.json");
    $books = json_decode($json, true);

    if (isset($_GET["id"])) $id = $_GET["id"];

    // Check the POST parameter "bookid". If it's set, delete the corresponding book from the data file.
    // Hint: array_diff will not work here, since you'd need to create the whole book "object". Find the index and use array_splice instead.

    // Redirect back to admin.php.

    // Once you have removed the book from the variable $books write it into the file.
    file_put_contents("assets/books.json", json_encode($books));

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
                <li><a href="admin.php">Admin Home</a></li>
                <li><a href="addbook.php">Add a New Book</a></li>
                <li><a href="login.php?logout">Log Out</a></li>
            </ul>
        </nav>
        <main>
            <h2><?php echo "Deleting book id $id: " . $books[$id]["title"] ?>
            </h2>
            <form action="deletebook.php" method="post">
                <p>
                    <label for="bookid">ID:</label>
                    <span><?php echo $id ?></span>
                </p>
                <p>
                    <label for="title">Title:</label>
                    <span><?php echo $books[$id]["title"] ?></span>
                </p>
                <p>
                    <label for="author">Author:</label>
                    <span><?php echo $books[$id]["author"] ?></span>
                </p>
                <p>
                    <label for="year">Year:</label>
                    <span></span><?php echo $books[$id]["publishing_year"] ?></span>
                </p>
                <p>
                    <label for="genre">Genre:</label>
                    <span><?php echo $books[$id]["genre"] ?></span>
                </p>
                <p>
                    <label for="description">Description:</label>
                    <span><?php echo $books[$id]["description"] ?></span>
                    <!-- need to make description text into a block. maybe a div and flex the parent -->
                </p>
                <input type="submit" name="delete-book" value = "Delete book">
                <a href="admin.php"><input type="submit" value = "Cancel"></a>
                <p class = "error_msg">The book will be permanently delete</p>
            </form>
        </main>
    </div>    
</body>
</html>
