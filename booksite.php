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
                <li><a href="booksite.php?genre=adventure">Adventure</a></li>
                <li><a href="booksite.php?genre=classic%20literature">Classic Literature</a></li>
                <li><a href="booksite.php?genre=coming-of-age">Coming-of-age</a></li>
                <li><a href="booksite.php?genre=fantasy">Fantasy</a></li>
                <li><a href="booksite.php?genre=historical%20fiction">Historical Fiction</a></li>
                <li><a href="booksite.php?genre=horror">Horror</a></li>
                <li><a href="booksite.php?genre=mystery">Mystery</a></li>
                <li><a href="booksite.php?genre=romance">Romance</a></li>
                <li><a href="booksite.php?genre=science%20fiction">Science Fiction</a></li>
            </ul>
        </nav>
        <main>
            <?php           
                $json = file_get_contents("assets/books.json");
                $books = json_decode($json, true);
                
                if (isset($_GET["genre"])) {
                    $genre = $_GET["genre"];
                    $filteredBooks = array_filter($books, fn($book) => $book["genre"] == ucwords($genre));
                } else {
                    $genre = "All";
                    $filteredBooks = $books;
                }

                echo "<h2>" . ucwords($genre) . "</h2>";

                foreach($filteredBooks as $book) { ?>
                <section class="book">
                    <?php 
                        if(isset($_COOKIE["favorites"]) && in_array($book["id"], explode(",", $_COOKIE["favorites"]))) {
                    ?>      <a class="bookmark fa fa-star" href="setfavorite.php?remove=<?php echo $book["id"] ?>"></a>
                    <?php } else { ?>
                            <a class="bookmark fa fa-star-o" href="setfavorite.php?add=<?php echo $book["id"] ?>"></a>
                    <?php } ?>

                    <h3><?php echo $book["title"] ?></h3>
                    <p class="publishing-info">
                        <span class="author"><?php echo $book["author"] ?></span>,
                        <span class="year"><?php echo $book["publishing_year"] ?></span>
                    </p>
                    <p class="description"><?php echo $book["description"] ?></p>
                </section>

            <?php } ?>

        </main>
    </div>    
</body>
</html>