<?php
session_start();
if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
  header("location: http://localhost:8000/");
}
include("../database.php");
$showError = false;
$showAlert = false;
if (isset($_POST["create-acc"])) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $pass = $_POST["pass"];
  $cpass = $_POST["cpass"];
  $authorid = uniqid();

  if (strlen($name) <= 20) {
    if (strlen($pass) >= 8 && strlen($cpass) >= 8) {
      if ($pass == $cpass) {
        $passHash = password_hash($pass, PASSWORD_BCRYPT);
        $members_list = "SELECT * FROM `members` WHERE `email` = '$email';";
        $membersListSqlReslut = mysqli_query($conn, $members_list);
        $list_numbers = mysqli_num_rows($membersListSqlReslut);
        if ($list_numbers == 0) {
          $insertMemberInfo = "INSERT INTO `members` (`author-id`, `name`, `email`, `password`, `profile-picture`, `join-time`) VALUES ('$authorid', '$name', '$email', '$passHash', 'noAvatar.jpg', current_timestamp());";
          $insertMemberReslut = mysqli_query($conn, $insertMemberInfo);
          if ($insertMemberReslut) {
            $_SESSION["logged"] = true;
            $_SESSION["authorid"] = $authorid;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $email;
            $_SESSION["pass"] = $pass;

            $showAlert = "Thanks for joining us";
            header("refresh:3;url=http://localhost:8000/");
          } else {
            $showError = "Unknown error, Check your inputs";
          }
        } else {
          $showError = "An account already exist with this email";
        }
      } else {
        $showError = "Password is not matching";
      }
    } else {
      $showError = "Password must be >= 8 characters";
    }
  } else {
    $showError = "Name must be <= 20 characters";
  }
}
if (isset($_POST["login-submit"])) {
  $login_name = $_POST["login-name"];
  $login_email = $_POST["login-email"];
  $login_pass = $_POST["login-pass"];

  $accountExistSql = "SELECT * FROM members WHERE email = '$login_email' AND name = '$login_name';";
  $doesAccountExist = mysqli_query($conn, $accountExistSql);
  $accountNumbers = mysqli_num_rows($doesAccountExist);
  if ($accountNumbers == 1) {
    while ($row = mysqli_fetch_assoc($doesAccountExist)) {
      if (password_verify($login_pass, $row["password"])) {
        $_SESSION["logged"] = true;
        $_SESSION["authorid"] = $row["author-id"];
        $_SESSION["name"] = $login_name;
        $_SESSION["email"] = $login_email;
        $_SESSION["pass"] = $login_pass;
        $showAlert = "Logged in to your account";
        header("refresh:3;url=http://localhost:8000/");
      } else {

        $showError = "Wrong password";
      }
    }
  } else {
    $showError = "Account does not exist";
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
        CREATE A NEW ACCOUNT
      </div>
      <div class="card-body bg-white">
        <input required autocomplete="off" type="text" name="name" placeholder="Enter your name...(Character limit 20)" class="shadow form-control mb-3">
        <input required autocomplete="off" type="email" name="email" placeholder="Enter your email..." class="shadow form-control mb-3">
        <input required autocomplete="off" type="password" name="pass" placeholder="Create a password..." class="shadow form-control mb-3">
        <input required autocomplete="off" type="password" name="cpass" placeholder="Re-type the password..." class="shadow form-control mb-3">
      </div>
      <input value="Create Account" class="btn my-0 btn-secondary btn-block" type="submit" name="create-acc">
    </form>
  </div>


  <p class="text-muted end-message py-5 fw-bold text-center">
    <!--<i class="bi bi-dot"></i>-->
    ~ or ~
  </p>


  <div class="input-wrap">
    <form style="width: 90vw;" class="input-div bg-light shadow" method="post">
      <div class="card-header shadow px-5 d-block heading">
        LOG IN TO YOUR ACCOUNT
      </div>
      <div class="card-body bg-white">
        <input required type="text" name="login-name" placeholder="Enter your name..." class="shadow form-control mb-3">
        <input required type="email" name="login-email" placeholder="Enter your email..." class="shadow form-control mb-3">
        <input required type="password" name="login-pass" placeholder="Enter the password..." class="shadow form-control mb-3">
      </div>
      <input value="Log In" class="btn my-0 btn-secondary btn-block" type="submit" name="login-submit">
    </form>
  </div>
  <?php include("../footer.php") ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>