<?php
    session_start();
    if (!isset($_SESSION["is_admin"])) header("Location: login.php");

    $json = file_get_contents("assets/books.json");
    $books = json_decode($json, true);

    if (isset($_GET["id"])) $id = $_GET["id"];
    ["title" => $title, "author" => $author, "publishing_year" => $year, "genre" => $genre, "description" => $description] = $books[$id]; //deconstruction book array

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION["deleted_book"] = $books[$id];
        array_splice($books, $id, 1);
        file_put_contents("assets/books.json", json_encode($books));
        header("Location: admin.php");
    }

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
            <h2><?php echo "Deleting book id $id: " . $title ?>
            </h2>
            <form action="deletebook.php?id=<?php echo $id ?>" method="post">
                <p>
                    <label for="bookid">ID:</label>
                    <span><?php echo $id ?></span>
                </p>
                <p>
                    <label for="title">Title:</label>
                    <span><?php echo $title ?></span>
                </p>
                <p>
                    <label for="author">Author:</label>
                    <span><?php echo $author ?></span>
                </p>
                <p>
                    <label for="year">Year:</label>
                    <span></span><?php echo $year ?></span>
                </p>
                <p>
                    <label for="genre">Genre:</label>
                    <span><?php echo $genre ?></span>
                </p>
                <p>
                    <label for="description">Description:</label>
                    <span><?php echo $description ?></span>
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
