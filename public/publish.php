<?php
session_start();
include("../database.php");
$showError = false;
$showAlert = false;
if (!isset($_SESSION["logged"]) && $_SESSION["logged"] != true) {
  header("location: http://localhost:8000/");
}
if (isset($_POST["submit-post"])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $article = $_POST['article'];
  $postid = uniqid();
  $authorid = $_SESSION["authorid"];
  $authorname = $_SESSION["name"];
  $authoremail = $_SESSION["email"];

  $title = str_replace("'", "&#39", $title);
  $title = str_replace("`", "&#96", $title);

  $title = str_replace('"', "&#34", $title);
  $title = str_replace("<", "&#60", $title);
  $title = str_replace(">", "&#62", $title);

  $title = str_replace(";", "&#59", $title);

  $description = str_replace("'", "&#39", $description);
  $description = str_replace("`", "&#96", $description);

  $description = str_replace('"', "&#34", $description);
  $description = str_replace("<", "&#60", $description);
  $description = str_replace(">", "&#62", $description);

  $description = str_replace(";", "&#59", $description);

  $article = str_replace("'", "&#39", $article);
  $article = str_replace("`", "&#96", $article);
  /*
  $article = str_replace('"',"&#34;",$article);
  $article = str_replace("<","&#60;",$article);
  $article = str_replace(">","&#62;",$article);
  */
  $article = str_replace(";", "&#59", $article);


  if (strlen($article) >= 700) {
    if (strlen($title) <= 250) {
      if (strlen($description) <= 450 || strlen($description) >= 300) {
        $insertPostSql = "INSERT INTO `posts` (`post-id`, `title`, `description`, `article`, `author-id`, `author-name`, `author-email`, `post-time`) VALUES ('$postid', '$title', '$description', '$article', '$authorid', '$authorname', '$authoremail', current_timestamp());";
        $insertQuery = mysqli_query($conn, $insertPostSql);
        if ($insertQuery) {
          $showAlert = "Your article have been posted";
        } else {
          $showError = "Unknown error, Check your inputs";

        }
      } else {
        $showError = "Description must be <= 450 and >= 300 characters long";
      }
    } else {
      $showError = "Title must be <= 250 characters";
    }
  } else {
    $showError = "Article must be >= 700 characters";
  }
}
/*
$str = "hello this is my text and I am happy";
$sliced = substr($str,0,4)."...";
echo($sliced);
*/
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
  <title>MediaTek</title>
  <style>
@import url('https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap');
    /* font-family: 'Titillium Web', sans-serif; */
@import url('https://fonts.googleapis.com/css2?family=Alegreya&display=swap');
    /* font-family: 'Alegreya', serif; */
@import url('https://fonts.googleapis.com/css2?family=Arvo&display=swap');
    /* font-family: 'Arvo', serif; */
    .navbar-nav,.alert,.card {
      font-family: 'Alegreya', serif;
    }
    .navbar-brand,.end-message {
      font-family: 'Arvo', serif;
    }
    .input-div {
      display: inline-block;
      font-family: 'Alegreya', serif;
    }
    .input-wrap {
      text-align: center;
    }
    .footer-div {
      font-family: 'Alegreya', serif;
    }
    .footer-div .introduction,.contact {
      line-height: 3px;
    }
    .footer-div .contact p {
      font-size: 11px;
    }
    .footer-div #contact_link {
      color: white;
      cursor: pointer;
    }

    #brandImg:hover {
      border: 2px dashed rgb(190,201,187);
      transition: all .4s;

    }
  </style>
</head>
<body>
  <?php include("../navbar.php") ?>
  <?php
  if ($showError) {
    echo('<div class="alert shadow alert-danger alert-dismissible fade show" role="alert">
  <strong>Error: </strong>'.$showError.'.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
  }
  if ($showAlert) {
    echo('<div class="alert shadow alert-success alert-dismissible fade show" role="alert">
  <strong>Success: </strong>'.$showAlert.'.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
  }
  ?>
  <div class="input-wrap">
    <form style="width: 90vw;" class=" mt-5 input-div bg-light shadow" method="post">
      <div class="card-header shadow px-5 d-block heading">
        PUBLISH NEW POST
      </div>
      <div class="card-body bg-white">

        <textarea required rows="2" type="text" name="title" placeholder="Character limit 250" class="shadow form-control mb-3">Give a title...</textarea>

        <textarea required rows="5" type="text" name="description" placeholder="Character limit 350" class="shadow form-control mb-3">Give a description...</textarea>
        <textarea required rows="8" type="text" name="article" placeholder="Make it Clean and Non-Abusive" class="shadow form-control mb-1">Your Article...</textarea>
      </div>
      <input value="Post Now!" class="btn my-0 btn-secondary btn-block" type="submit" name="submit-post">
    </form>
  </div>
  <?php include("../footer.php") ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>