<?php
    session_start();
    if (!isset($_SESSION["is_admin"])) header("Location: login.php");

    // if the form has been sent, add the book to the data file

    // In order to protect against cross-site scripting attacks (i.e. basic PHP security), remove HTML tags from all input.
    // There's a function for that. E.g.
    // $title = strip_tags($_POST["title"]);

    // Read the file into array variable $books:
    $json = file_get_contents("assets/books.json");
    $books = json_decode($json, true);

    isset($_GET["id"]) ? $id = $_GET["id"] : $id = end($books)["id"] + 1;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["title"]) && empty($_POST["author"]) && empty($_POST["year"])&& empty($_POST["description"])) {
            $error_msg = "Please enter all fields!";
        } else {
            $error_msg = "";
            $books[$id] = (Object) [
                "id" => $id,
                "title" => $_POST["title"],
                "description" => $_POST["description"],
                "author" => $_POST["author"],
                "publishing_year" => $_POST["year"],
                "genre" => $_POST["genre"]
            ];
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
            <?php isset($_GET["id"]) ? print "Edit book id $id: " . $books[$id]["title"] : print "Add a New Book" ?>
            <!-- need to add name here to know which book is being edit -->
            </h2>
            <form action="addbook.php" method="post">
                <p>
                    <label for="bookid">ID:</label>
                    <span><?php echo $id ?></span>
                </p>
                <p>
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo @$books[$id]["title"] ?>">
                </p>
                <p>
                    <label for="author">Author:</label>
                    <input type="text" id="author" name="author" value="<?php echo @$books[$id]["author"] ?>">
                </p>
                <p>
                    <label for="year">Year:</label>
                    <input type="number" id="year" name="year"  value=<?php echo @$books[$id]["publishing_year"] ?>>
                </p>
                <p>
                    <label for="genre">Genre:</label>
                    <select id="genre" name="genre">
                        <option value="Adventure" <?php if (@$books[$id]["genre"] == "Adventure") echo "selected" ?>>Adventure</option>
                        <option value="Classic Literature" <?php if (@$books[$id]["genre"] == "Classic Literature") echo "selected" ?> >Classic Literature</option>
                        <option value="Coming-of-age" <?php if (@$books[$id]["genre"] == "Coming-of-age") echo "selected" ?>>Coming-of-age</option>
                        <option value="Fantasy" <?php if (@$books[$id]["genre"] == "Fantasy") echo "selected" ?>>Fantasy</option>
                        <option value="Historical Fiction" <?php if (@$books[$id]["genre"] == "Historical Fiction") echo "selected" ?>>Historical Fiction</option>
                        <option value="Horror" <?php if (@$books[$id]["genre"] == "Horror") echo "selected" ?>>Horror</option>
                        <option value="Mystery" <?php if (@$books[$id]["genre"] == "Mystery") echo "selected" ?>>Mystery</option>
                        <option value="Romance" <?php if (@$books[$id]["genre"] == "Romance") echo "selected" ?>>Romance</option>
                        <option value="Science Fiction" <?php if (@$books[$id]["genre"] == "Science Fiction") echo "selected" ?>>Science Fiction</option>
                    </select>
                </p>
                <p>
                    <label for="description">Description:</label><br>
                    <textarea rows="5" cols="100" id="description" name="description"><?php echo @$books[$id]["description"] ?></textarea>
                </p>
                <input type="submit" name="add-book" value="<?php isset($_GET["id"]) ? print "Edit" : print "Add" ?> Book">
                <p class = "error_msg"><?php echo @$error_msg ?></p>
            </form>
        </main>
    </div>    
</body>
</html>