<?php
session_start();


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
    .navbar-nav,.card {

      font-family: 'Alegreya', serif;
    }
    .navbar-brand {
      font-family: 'Arvo', serif;

    }
    .alert {
      font-family: 'Arvo', serif;
      font-size: 11px;
    }
    .card {
      margin: auto 6px;
      max-width: 19rem;
      display: inline-block;
      text-align: left;
    }
    .cards-wrap-div {

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

  <div height="40" class="shadow alert alert-white mb-4" role="alert">
    <marquee class="text-muted" height="14" width="100%" direction="left">
      <?php
      include("../database.php");
      $getTitlesSql = "SELECT * FROM `posts`";
      $titlesQuery = mysqli_query($conn, $getTitlesSql);

      while ($titlesRow = mysqli_fetch_assoc($titlesQuery)) {
        echo('<a class="text-dark" href="full-post?id='.$titlesRow["post-id"].'">'.$titlesRow["title"].'</a><span> <i class="bi bi-dot"></i></span>');
      }
      ?>

    </marquee>
  </div>
  <div class="cards-wrap-div">
    <?php
    include("../database.php");
    $getPostsSql = "SELECT `title`,`description`,`post-id`,`author-id`,`author-name`, EXTRACT( DAY FROM `post-time`) as 'date', EXTRACT( MONTH FROM `post-time`) as 'month', EXTRACT( YEAR FROM `post-time`) as 'year' FROM `posts`;";
    $postsQuery = mysqli_query($conn, $getPostsSql);

    while ($postList = mysqli_fetch_assoc($postsQuery)) {
      $authorId = $postList["author-id"];
      $postId = $postList["post-id"];
      $title = $postList["title"];
      $descRaw = $postList["description"];
      $desc = substr($descRaw, 0, 250)."...";
      $day = $postList["date"];
      $year = $postList['year'];
      $monthNum = $postList['month'];
      $month = date("F", strtotime("$year-$monthNum-$day"));

      if (isset($_SESSION["logged"]) && $_SESSION["email"] == $postList["author-email"]) {
        $authorName = "You!";
        echo('<div class="card mb-3 " style="width: 20rem;">
      <div class="card-header">
        <h5 class="card-title">'.$title.'</h5>
        <h6 class="card-subtitle mb-2 text-muted"><blockquote class="blockquote mb-0">

          <footer class="blockquote-footer">
            Written by <cite title="Post Author Name">'.$authorName.'</cite>
          </footer>
        </blockquote>
        </h6>
      </div>
      <div class="card-body">
        <p class="card-text">
          '.
          $desc
          .'
        </p>
        <a href="full-post?id='.$postId.'" class="btn btn-secondary card-link">Read full</a>
        <a href="profile?id='.$authorId.'" class="btn btn-secondary card-link">About author</a>
      </div>
      <div class="card-footer text-muted">
        <i class="bi bi-clock"></i> '.$day.'/'.$month.'/'.$year.'
      </div>
    </div>');
      } else {
        $authorName = $postList["author-name"];
        echo('<div class="card mb-3 " style="width: 20rem;">
      <div class="card-header">
        <h5 class="card-title">'.$title.'</h5>
        <h6 class="card-subtitle mb-2 text-muted"><blockquote class="blockquote mb-0">

          <footer class="blockquote-footer">
            Written by <cite title="Post Author Name">'.$authorName.'</cite>
          </footer>
        </blockquote>
        </h6>
      </div>
      <div class="card-body">
        <p class="card-text">
          '.
          $desc
          .'
        </p>
        <a href="full-post?id='.$postId.'" class="btn btn-secondary card-link">Read full</a>
        <a href="profile?id='.$authorId.'" class="btn btn-secondary card-link">About author</a>
      </div>
      <div class="card-footer text-muted">
        <i class="bi bi-clock"></i> '.$day.'/'.$month.'/'.$year.'
      </div>
    </div>');
      }

    }
    ?>

  </div>

  <?php include("../footer.php") ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>