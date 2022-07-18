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
    .navbar-nav,.alert,.card {
      font-family: 'Alegreya', serif;
    }
    .navbar-brand,.end-message {
      font-family: 'Arvo', serif;
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
    .alert-wrap {
      min-height: 80vh;
    }

  </style>
</head>
<body>
  <?php include("../navbar.php") ?>

  <?php
  include("../database.php");
  $KEYWORD = $_GET["keyword"];
  $getSearchSql = "SELECT `title`,`post-id` FROM `posts` WHERE `title` LIKE '%$KEYWORD%' ";
  $getSearchQuery = mysqli_query($conn, $getSearchSql);
  $numSearches = mysqli_num_rows($getSearchQuery);
  echo('<div class="alert-wrap">  <div class="alert text-break shadow alert-white" role="alert">
    <h5 class="fw-bold text-muted alert-heading">Search Query: "'.$_GET["keyword"].'"</h5>
    <p>Showing '.$numSearches.' results related to your Query :) </p>
    <hr>
    <div class="results">');
  while ($reslutRow = mysqli_fetch_assoc($getSearchQuery)) {
    $str = $reslutRow["title"];
    $sliced = substr($str, 0, 38)."...";
    $postId = $reslutRow["post-id"];

    echo('<p class="mb-0 d-inline-block text-truncate" style="max-width: 85vw;">
      <span class="text-muted">~ </span><a href="full-post?id='.$postId.'">'.$str.'</a>
    </p>');
  }

  ?>

</div>
</div>
</div>

<?php include("../footer.php") ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>