<?php
    session_start();
    if (!isset($_SESSION["is_admin"])) header("Location: login.php");

    $json = file_get_contents("assets/books.json");
    $books = json_decode($json, true);

    isset($_GET["id"]) ? $id = $_GET["id"] : $id = end($books)["id"] + 1; //when editing books, id variable is given by link GET parameter. When adding book, id is the last book in JSON array plus 1.
    ["title" => $title, "author" => $author, "publishing_year" => $year, "genre" => $genre, "description" => $description] = @$books[$id]; //deconstruct book infos array

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //strip_tags is method to prevent code injection from input
        if (empty(strip_tags($_POST["title"])) && empty(strip_tags($_POST["author"])) && empty(strip_tags($_POST["year"])) && empty(strip_tags($_POST["description"]))) {
            $error_msg = "Please enter all fields!";
        } else {
            $error_msg = "";
            $books[$id] = (Object) [
                "id" => $id,
                "title" => strip_tags($_POST["title"]),
                "description" => strip_tags($_POST["description"]),
                "author" => strip_tags($_POST["author"]),
                "publishing_year" => strip_tags($_POST["year"]),
                "genre" => strip_tags($_POST["genre"])
            ]; //construct the book object and add it into $books array at index $id
            file_put_contents("assets/books.json", json_encode($books));
            header("Location: admin.php");
        }
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
            <h2>
            <?php isset($_GET["id"]) ? print "Edit book id $id: " . $title : print "Add a New Book" ?>
            </h2>
            <form action="addbook.php<?php if(isset($_GET["id"])) echo "?id=$id" ?>" method="post">
            <!-- pass the GET["id"] if form is sent when GET parameter is presence (editing book) -->
                <p>
                    <label for="bookid">ID:</label>
                    <span><?php echo $id ?></span>
                </p>
                <p>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo @$title ?>">
                </p>
                <p>
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" value="<?php echo @$author ?>">
                </p>
                <p>
                    <label for="year">Year:</label>
                    <input type="number" id="year" name="year"  value=<?php echo @$year ?>>
                </p>
                <p>
                    <label for="genre">Genre:</label>
                    <select id="genre" name="genre">
                        <option value="Adventure" <?php if (@$genre == "Adventure") echo "selected" ?>>Adventure</option>
                        <option value="Classic Literature" <?php if (@$genre == "Classic Literature") echo "selected" ?> >Classic Literature</option>
                        <option value="Coming-of-age" <?php if (@$genre == "Coming-of-age") echo "selected" ?>>Coming-of-age</option>
                        <option value="Fantasy" <?php if (@$genre == "Fantasy") echo "selected" ?>>Fantasy</option>
                        <option value="Historical Fiction" <?php if (@$genre == "Historical Fiction") echo "selected" ?>>Historical Fiction</option>
                        <option value="Horror" <?php if (@$genre == "Horror") echo "selected" ?>>Horror</option>
                        <option value="Mystery" <?php if (@$genre == "Mystery") echo "selected" ?>>Mystery</option>
                        <option value="Romance" <?php if (@$genre == "Romance") echo "selected" ?>>Romance</option>
                        <option value="Science Fiction" <?php if (@$genre == "Science Fiction") echo "selected" ?>>Science Fiction</option>
                    </select>
                </p>
                <p>
                    <label for="description">Description:</label><br>
                    <textarea rows="5" cols="100" id="description" name="description"><?php echo @$description ?></textarea>
                </p>
                <input type="submit" name="add-book" value="<?php isset($_GET["id"]) ? print "Edit" : print "Add" ?> Book">
                <p class = "error_msg"><?php echo @$error_msg ?></p>
            </form>
        </main>
    </div>    
</body>
</html>