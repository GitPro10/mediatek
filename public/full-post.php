<?php


session_start();
include("../database.php");
$showAlert = false;
$showError = false;
if (isset($_POST["submit-comment"])) {
  $commenter = $_SESSION["name"];
  $commentID = uniqid();
  $userId = $_SESSION["authorid"];
  $comment = $_POST["comment"];
  $postID = $_GET["id"];
  $commenterEmail = $_SESSION["email"];

  $comment = str_replace("'", "&#39", $comment);
  $comment = str_replace("`", "&#96", $comment);

  $comment = str_replace('"', "&#34", $comment);
  $comment = str_replace("<", "&#60", $comment);
  $comment = str_replace(">", "&#62", $comment);

  $comment = str_replace(";", "&#59", $comment);



  if (strlen($comment) <= 300) {
    $insertCommentSql = "INSERT INTO `comments` (`comment-id`, `name`, `comment`, `post-id`, `email`, `userid`, `comment-time`) VALUES ('$commentID', '$commenter', '$comment', '$postID', '$commenterEmail', '$userId', current_timestamp());";
    $insertCommentQuery = mysqli_query($conn, $insertCommentSql);
    if ($insertCommentQuery) {
      $showAlert = "Your comment have been submitted";
    } else {
      $showError = "Unknown error, Check your inputs";

    }

  } else {
    $showError = "Comment must be <= 300 characters";
  }
}
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

    .navbar-nav,.card,.fullpost,.not-logged-message,.alert {
      font-family: 'Alegreya', serif;
    }
    .navbar-brand,.end-message {
      font-family: 'Arvo', serif;
    }
    .fullpost a {
      text-decoration: underline;
      color: rgba(255,125,125,0.714);
      font-weight: bold;
    }
    .fullpost a:hover {
      color: rgba(249,100,100,0.94);
    }
    .fullpost a:active {
      color: rgb(240,145,145)
    }
    .fullpost a:visited {
      color: rgba(252,161,131,0.92);
    }
    .fullpost img {
      margin-top: 10px;
      margin-bottom: 10px;
      display: block;
      margin-left: auto;
      margin-right: auto;
      border-radius: 6px;
      width: 80vw;
      height: 300px;
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
    echo('<div class="alert mb-0 shadow alert-danger alert-dismissible fade show" role="alert">
  <strong>Error: </strong>'.$showError.'.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
  }
  if ($showAlert) {
    echo('<div class="alert mb-0 shadow alert-success alert-dismissible fade show" role="alert">
  <strong>Success: </strong>'.$showAlert.'.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
  }
  ?>
  <div class="fullpost px-4 text-break text-left py-3 bg-white shadow mb-4">
    <?php
    include("../database.php");
    $postId = $_GET["id"];

    $getPostsSql = "SELECT * FROM `posts` WHERE `post-id` = '$postId'";
    $postsQuery = mysqli_query($conn, $getPostsSql);


    while ($postList = mysqli_fetch_assoc($postsQuery)) {
      $postTitle = $postList["title"];
      $postDeec = $postList["description"];
      $postArticle = $postList["article"];

      echo('
   <h5 class="fw-bold">'.$postTitle.'</h5>

    <small class="text-muted fw-bold">'.$postDeec.'</small>
    <hr>
    <br>
    <p>
      '.
        $postArticle
        .'
    </p>
  </div>');
    }

    echo('<form method="post" class="mb-4 form">
    <div class="card shadow">
      <div class="card card-header">
        <h5 class="fw-bold text-muted">Comment</h5>
      </div>
      <div class="card-body">');
    if (isset($_SESSION["logged"])) {
      echo('  <textarea required rows="6" type="text" name="comment" placeholder="Character limit 300" class="shadow form-control mb-1">Your Comment...</textarea>
        <input type="submit" name="submit-comment" value="Comment" class="shadow btn btn-block btn-secondary">');
    } else {
      echo('<p class="text-muted not-logged-message text-center">Sorry, you can\'t comment. You have to logged in to any of your accounts to access comment box.</p>');
    }

    echo('</div>
    </div>
  </form>');
    $pid = $_GET["id"];
    $getComments = "SELECT `name`,`comment`,`comment-id`,`email`,`userid`, EXTRACT( DAY FROM `comment-time`) as 'date', EXTRACT( MONTH FROM `comment-time`) as 'month', EXTRACT( YEAR FROM `comment-time`) as 'year', EXTRACT( HOUR FROM `comment-time`) as 'hour', EXTRACT( MINUTE FROM `comment-time`) as 'minute' FROM `comments` WHERE `post-id` = '$pid';";
    $getCommentsQuery = mysqli_query($conn, $getComments);

    $numComments = mysqli_num_rows($getCommentsQuery);

    echo('
  <div class="card shadow">
    <div class="card card-header">
      <h5 class="fw-bold text-muted">Comments – '.$numComments.'</h5>
    </div>
    <div class="card-body bg-white px-2 py-2">');
    if ($numComments == 0) {
      echo('<p class="text-muted not-logged-message text-center">Sorry, no comments to show.</p>');
    } else {

      while ($commentsList = mysqli_fetch_assoc($getCommentsQuery)) {

        $name = $commentsList["name"];
        $comment = $commentsList["comment"];
        $commentId = $commentsList["comment-id"];
        $email = $commentsList["email"];


        $day = $commentsList["date"];
        $year = $commentsList['year'];
        $monthNum = $commentsList['month'];
        $month = date("F", strtotime("$year-$monthNum-$day"));
        $hour = $commentsList["hour"];
        $minute = $commentsList["minute"];
        $amorpm = date("a", strtotime("$year-$monthNum-$day"));
        $sqlGetCommenterInfo = "SELECT `author-id`,`profile-picture` FROM `members` WHERE `email` = '$email'";
        $commentInfoQuery = mysqli_query($conn, $sqlGetCommenterInfo);
        $commentInfo = mysqli_fetch_assoc($commentInfoQuery);
        $profileAvatar = $commentInfo["profile-picture"];
        $userUniqueId = $commentInfo["author-id"];

        echo('<ul class="list-unstyled rounded px-2 py-1 ">
        <li class="media">
          <img src="Avatar/'.$profileAvatar.'" width="55" height="55" class="rounded-circle mr-3" alt="User Avatar">
          <div class="media-body text-break">
            <p class="font-weight-bold my-0">
              <a class="text-dark" href="profile?id='.$userUniqueId.'">'.$name.'</a> <span class="badge badge-secondary">'.$day.'/'.$month.'/'.$year.' – '.$hour.':'.$minute.' '.$amorpm.'</span>
            </p>
            <p class="font-weight-lighter my-0">

            </p>
            <p class="font-italic">
              '.
          $comment
          .'
            </p>
          </div>
        </li>
      </ul>
  ');
      }

    }
    echo(" </div></div>");
    ?>
  </div>




  <?php include("../footer.php") ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>