<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

require 'classes/Post.php';
require 'classes/PostLoader.php';
session_start();

if (isset($_SESSION['posts'])){
    $posts = $_SESSION['posts'];
} else {
    $posts = new PostLoader();
}

$success = "";
$error = 'border-danger';
$title = $message = $author = "";
$titleError = $messageError = $authorError = "";
$titleStyle = $messageStyle = $authorStyle = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST['title'])){
        $titleError = 'Title is required!';
        $titleStyle = $error;
    } else {
        $title = inputCheck($_POST["title"]);
    }

    if (empty($_POST['author'])){
        $authorError = 'Name is required!';
        $authorStyle = $error;
    } else {
        $author = inputCheck($_POST["author"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $author)){
            $authorError = 'Name can only contain letters and spaces!';
            $authorStyle = $error;
        }
    }
    if (empty($_POST['message'])){
        $messageError = 'Message is required!';
        $messageStyle = $error;
    } else {
        $message = inputCheck($_POST["message"]);
    }
    if ($authorError === "" && $messageError === "" && $titleError === ""){
        $posts->newPost($title, $message, $author);

        $success = '<div class="alert alert-success" role="alert"> Message sent </div>';
    }
}

function inputCheck($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

$_SESSION['posts'] = $posts;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css" type="text/css">
    <title>Guestbook</title>
</head>
<body>
<?php echo $success; ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form">
    * = required <br>
    <label for="title" id="title"> Title </label><br>
    <input type="text" id="title" name="title" placeholder="Title" value="<?php echo $title ?>" class="border rounded <?php echo $titleStyle ?>"><br>
    <span>*<?php echo $titleError ?></span><br>
    <label for="author" id="author"> Name </label><br>
    <input type="text" id="author" name="author" placeholder="Name" value="<?php echo $author ?>" class="border rounded <?php echo $authorStyle ?>"><br>
    <span>*<?php echo $authorError ?></span><br>
    <label for="message" id="message"> Message </label><br>
    <input type="text" id="message" name="message" placeholder="Message" value="<?php echo $message ?>" class="border rounded <?php echo $messageStyle ?>"><br>
    <span>*<?php echo $messageError ?></span><br>
    <input type="submit" value="Submit">
</form>
<h1>Guestbook</h1>
<div>
    <?php
    $posts->printPosts();
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>
</body>
</html>
