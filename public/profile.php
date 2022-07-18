<?php
session_start();

if (!isset($_SESSION["logged"]) && $_SESSION["logged"] != true) {
  header("location: http://localhost:8000/");
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
    .navbar-nav,.alert,.card,.card-header,.profile-info,.posts-counter,.no-post-message {
      font-family: 'Alegreya', serif;
    }
    .navbar-brand,.end-message {
      font-family: 'Arvo', serif;
    }
    .posts-counter {
      line-height: 7px;
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
    .profile-info-wrap {
      min-height: 80vh;
    }
  </style>
</head>
<body>
  <?php include("../navbar.php") ?>
  <div class="profile-info-wrap">
    <div class="shadow bg-light profile-info d-flex justify-content-center mb-3 px-3 pt-4 pb-2">
      <?php
      include("../database.php");
      $profileId = $_GET["id"];
      if ($profileId == $_SESSION["authorid"]) {

        $getMemberInfoSql = "SELECT `name`,`email`,`password`,`profile-picture` FROM `members` WHERE `author-id` = '$profileId';";
        $getMemberInfoQuery = mysqli_query($conn, $getMemberInfoSql);
        while ($profileInfoRow = mysqli_fetch_assoc($getMemberInfoQuery)) {
          $name = $profileInfoRow["name"];
          $email = $profileInfoRow["email"];
          $pass = $_SESSION["pass"];
          $pfp_pathName = $profileInfoRow["profile-picture"];
          echo('<ul class="list-unstyled rounded ">
      <li class="media">

        <div class="image-part">
          <img width="110px" height="110px" class="rounded-circle mb-2 mr-3" alt="error" src="Avatar/'.$pfp_pathName.'">
          <p>
          '.
            $_SESSION["authorid"]
            .'
          </p>

        </div>

        <fieldset disabled>
          <div class="media-body text-break">

            <div class="input-group mt-2 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
              </div>
              <input value="'.$name.'" type="text" class=" form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mt-2 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
              </div>
              <input value="'.$email.'" type="email" class=" form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
            </div>
 <div class="input-group mt-2 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
              </div>
              <input value="'.$pass.'" type="text" class=" form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
           <p><a href="account-edit?id='.$profileId.'">Edit or Delete your Account ➪</a></p>
        </fieldset>
      </li>
    </ul>');
        }
        echo("</div>");

        $getPostsSql = "SELECT `title`,`description`,`post-id`,`author-id`,`author-name`, EXTRACT( DAY FROM `post-time`) as 'date', EXTRACT( MONTH FROM `post-time`) as 'month', EXTRACT( YEAR FROM `post-time`) as 'year' FROM `posts` WHERE `author-id` = '$profileId';";
        $postsQuery = mysqli_query($conn, $getPostsSql);
        $numPosts = mysqli_num_rows($postsQuery);
        echo('<div class="posts-counter pt-3 bg-light shadow text-center ">
    <p>
      Total Posts
    </p>
    <p class="bg-white d-inline-block">
      '.$numPosts.'
    </p>
  </div>');
        if ($numPosts == 0) {
          echo('<p class="text-muted pt-5 no-post-message text-center">Sorry, no posts found.</p>');
        } else {
          echo('<div class="cards-wrap-div pt-4">');
          while ($postList = mysqli_fetch_assoc($postsQuery)) {
            $authorId = $postList["author-id"];
            $postId = $postList["post-id"];
            $title = $postList["title"];
            $desc = $postList["description"];
            $day = $postList["date"];
            $year = $postList['year'];
            $monthNum = $postList['month'];
            $month = date("F", strtotime("$year-$monthNum-$day"));

            echo('<div class="card mb-3 " style="width: 20rem;">
      <div class="card-header">
        <h5 class="card-title">'.$title.'</h5>
        <h6 class="card-subtitle mb-2 text-muted"><blockquote class="blockquote mb-0">

          <footer class="blockquote-footer">
            Written by <cite title="Post Author Name">You!</cite>
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
      </div>
      <div class="card-footer text-muted">
        <i class="bi bi-clock"></i> '.$day.'/'.$month.'/'.$year.'
      </div>
    </div>');



          }
          echo("</div>");
        }
      } else {
        $getMemberInfoSql = "SELECT `name`,`email`,`password`,`profile-picture` FROM `members` WHERE `author-id` = '$profileId';";
        $getMemberInfoQuery = mysqli_query($conn, $getMemberInfoSql);
        while ($profileInfoRow = mysqli_fetch_assoc($getMemberInfoQuery)) {
          $name = $profileInfoRow["name"];
          $email = $profileInfoRow["email"];
          $pass = $_SESSION["pass"];
          $pfp_pathName = $profileInfoRow["profile-picture"];
          echo('<ul class="list-unstyled rounded ">
      <li class="media">
        <div class="image-part">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwmEPe2T-0Sq4KyhnAbUjNoA-VhMrzedkhYl1QvwW46Rid5qye0nrgThIf&s=10" width="90px" class="rounded-circle mb-2 mr-5" alt="error">
          <p>
          '.
            $_SESSION["authorid"]
            .'
          </p>

        </div>

        <fieldset disabled>
          <div class="media-body text-break">

            <div class="input-group mt-2 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
              </div>
              <input value="'.$name.'" type="text" class=" form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mt-2 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
              </div>
              <input value="'.$email.'" type="email" class=" form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1">
            </div>
 <div class="input-group mt-2 mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
              </div>
              <input value="'.$pass.'" type="text" class=" form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
        </fieldset>
      </li>
    </ul>');
        }
        echo("</div>");

        $getPostsSql = "SELECT `title`,`description`,`post-id`,`author-id`,`author-name`, EXTRACT( DAY FROM `post-time`) as 'date', EXTRACT( MONTH FROM `post-time`) as 'month', EXTRACT( YEAR FROM `post-time`) as 'year' FROM `posts` WHERE `author-id` = '$profileId';";
        $postsQuery = mysqli_query($conn, $getPostsSql);
        $numPosts = mysqli_num_rows($postsQuery);
        echo('<div class="posts-counter pt-3 bg-light shadow text-center ">
    <p>
      Total Posts
    </p>
    <p class="bg-white d-inline-block">
      '.$numPosts.'
    </p>
  </div>');
        if ($numPosts == 0) {
          echo('<p class="text-muted pt-5 no-post-message text-center">Sorry, no posts found.</p>');
        } else {
          echo('<div class="cards-wrap-div pt-4">');
          while ($postList = mysqli_fetch_assoc($postsQuery)) {
            $authorId = $postList["author-id"];
            $postId = $postList["post-id"];
            $title = $postList["title"];
            $desc = $postList["description"];
            $day = $postList["date"];
            $year = $postList['year'];
            $monthNum = $postList['month'];
            $month = date("F", strtotime("$year-$monthNum-$day"));

            echo('<div class="card mb-3 " style="width: 20rem;">
      <div class="card-header">
        <h5 class="card-title">'.$title.'</h5>
        <h6 class="card-subtitle mb-2 text-muted"><blockquote class="blockquote mb-0">

          <footer class="blockquote-footer">
            Written by <cite title="Post Author Name">You!</cite>
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
      </div>
      <div class="card-footer text-muted">
        <i class="bi bi-clock"></i> '.$day.'/'.$month.'/'.$year.'
      </div>
    </div>');



          }
          echo("</div>");
        }
      }

      ?>
    </div>
    <?php include("../footer.php") ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  </body>
</html>