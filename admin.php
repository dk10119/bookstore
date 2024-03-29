<?php
    session_start();
    if (!isset($_SESSION["is_admin"])) header("Location: login.php");
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
                <li><a href="booksite.php">To book site</a></li>
                <li><a href="addbook.php">Add a New Book</a></li>
                <li><a href="login.php?logout">Log Out</a></li>
            </ul>
        </nav>
        <main>
            <h2>All Books</h2>
            <?php     
                $json = file_get_contents("assets/books.json");
                $books = json_decode($json, true);

                foreach(array_reverse($books) as $book) { ?>
                <section class="book">
                    <a href="deletebook.php?id=<?php echo $book["id"] ?>"><button class = "edit_form">Delete</button></a>
                    <a href="addbook.php?id=<?php echo $book["id"] ?>"><button class="edit_form">Edit</button></a>
                    <!-- looks like redirect to addbook but it give a parameter so addbook page will recognize and change to edit book instead -->
                    <h3><?php echo $book["title"] ?></h3>
                    <p class="publishing-info">
                        <span class="author"><?php echo $book["author"] ?></span>,
                        <span class="year"><?php echo $book["publishing_year"] ?></span>
                    </p>
                    <p class="description"><?php echo $book["description"] ?></p>
                </section>
            <?php } ?>

            </section>
        </main>
    </div>    
</body>
</html>