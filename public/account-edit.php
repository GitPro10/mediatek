<?php
$showError = false;
$showAlert = false;
session_start();
include("../database.php");
$unique_id = $_GET["id"];
if (isset($_SESSION["logged"]) && $unique_id == $_SESSION["authorid"]) {} else {
  header("location: http://localhost:8000/signup");
}
if (isset($_POST["change-name"])) {
  $changed_name = $_POST["name"];
  if (strlen($changed_name) <= 20) {
    $changeNameSql = "UPDATE `members` SET `name` = '$changed_name' WHERE `members`.`author-id` = '$unique_id';";
    $updateNameQuery = mysqli_query($conn, $changeNameSql);
    if ($updateNameQuery) {
      $showAlert = 'Changed your name! Current name is "'.$changed_name.'"';
      $_SESSION["name"] = $changed_name;
    } else {
      $showError = "Unknown error, Check your inputs";
    }
  } else {
    $showError = "Name must be <= 20 characters";
  }
}
if (isset($_POST["change-email"])) {
  $changed_email = $_POST["email"];
  $checkEmailSql = "SELECT * FROM `members` WHERE `email` = '$changed_email';";
  $checkEmailQuery = mysqli_query($conn, $checkEmailSql);
  $numAccounts = mysqli_num_rows($checkEmailQuery);
  if ($numAccounts == 0) {

    $changeEmailSql = "UPDATE `members` SET `email` = '$changed_email' WHERE `members`.`author-id` = '$unique_id';";
    $updateEmailQuery = mysqli_query($conn, $changeEmailSql);
    if ($updateEmailQuery) {
      $showAlert = 'Changed your email';
      $_SESSION["email"] = $changed_email;
    } else {
      $showError = "Unknown error, Check your inputs";
    }
  } else {
    $showError = "This enail is not available";
  }
}
if (isset($_POST["change-password"])) {
  $changed_pass = $_POST["pass"];
  $changed_pass_confirm = $_POST["cpass"];
  if (strlen($changed_pass) >= 8 && strlen($changed_pass_confirm) >= 8) {
    if ($changed_pass == $changed_pass_confirm) {
      $passHash = password_hash($pass, PASSWORD_BCRYPT);
      $changePassSql = "UPDATE `members` SET `email` = '$changed_email' WHERE `members`.`password` = '$passHash';";
      $updatePassQuery = mysqli_query($conn, $changePassSql);
      if ($updatePassQuery) {
        $showAlert = "Changed your password";
        $_SESSION["pass"] = $changed_pass;
      }
    } else {
      $showError = "Password is not matching";
    }
  } else {
    $showError = "Password must be >= 8 characters";
  }
}
if (isset($_POST["delete-acc"])) {
  $deleteSql = "DELETE FROM `members` WHERE `members`.`author-id` = '$unique_id'";
  session_destroy();
  header("location: http://localhost:8000/signup");
}
if (isset($_POST["pfp"])) {
  $imgFile = $_FILES['pfpImage']['name'];
  $tmp_dir = $_FILES['pfpImage']['tmp_name'];
  $imgSize = $_FILES['pfpImage']['size'];
  if (!empty($imgFile)) {

    $upload_dir = 'Avatar/'; // upload directory

    $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

    // rename uploading image

    $coverpic = $unique_id."_MediaTekImage".".".$imgExt;

    // allow valid image file formats
    if (in_array($imgExt, $valid_extensions)) {
      // Check file size '2MB'
      if ($imgSize < 5000000) {
        move_uploaded_file($tmp_dir, $upload_dir.$coverpic);
        $que = "UPDATE `members` SET `profile-picture` = '$coverpic' WHERE `members`.`author-id` = '$unique_id';";

        if (mysqli_query($conn, $que)) {
          $showAlert = "Image uploaded";
        } else {
          $showError = "Unknown error, Check your inputs";
        }
      } else {
        $showError = "Image must be <= 5MB";
      }
    } else {
      $showError = "Unknown file extension";
    }

    //For Database Insertion
    // if no error occured, continue ....
  }
  echo(mysqli_error($conn));
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
    .navbar-nav,.card,.heading,.delete-acc-btn,.alert {
      font-family: 'Alegreya', serif;
    }
    .navbar-brand {
      font-family: 'Arvo', serif;
    }
    .alert {
      /*font-family: 'Arvo', serif;
     font-size: 11px;*/
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
    .btn-upload-image {
      opacity: 0.6;
      width: 70vw;
      font-family: 'Alegreya', serif;
    }
    .input-div,.all-input-wrap {
      display: inline-block;
      font-family: 'Alegreya', serif;
    }
    .input-wrap,.all-input {
      text-align: center;
      padding: 15px;
    }
    .form-input {
      display: inline-block;
      text-align: center;
      width: 70vw;
    }
    .form-input input {
      display: none;
    }
    .form-input label:hover {
      /* background: rgba(182,179,198,0.796);
      /*padding: 5px 20px;*/
      color: rgba(0,0,0,0.515);
      opacity: .7;

    }

    .form-input label {
      display: block;
      width: 100%;
      height: 6rem;
      line-height: 100px;
      text-align: center;


      background: rgb(190,214,237);
      color: rgba(54,54,54,0.785);

      font-weight: bold;
      font-size: 0.9rem;


      border-radius: 4px;
      cursor: pointer;
      transition: all .4s;
    }
    .fileName {
      display: none;
    }
    .form-input img {
      width: 13rem;
      height: 13rem;
      display: none;
      border: 2px dashed #ccc;
      text-align: center;
      margin-top: 10px;
      border-radius: 50%;
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
    echo('<div class="alert my-0 shadow alert-danger alert-dismissible fade show" role="alert">
  <strong>Error: </strong>'.$showError.'.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
  }
  if ($showAlert) {
    echo('<div class="alert my-0 shadow alert-success alert-dismissible fade show" role="alert">
  <strong>Success: </strong>'.$showAlert.'.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>');
  }
  ?>
  <div class="pt-4 pb-2 shadow bg-white text-center">
    <p class="heading">
      Account Management
    </p>
  </div>

  <div class="input-wrap d-flex justify-content-center">
    <form style="width: 90vw;" class="my-5 input-div bg-white shadow" method="post" enctype="multipart/form-data">

      <div class="card-body all-input-wrap">
        <small>Upload your profile pic</small>
        <div class="all-input">

          <div class="form-input">
            <label id="fileInputPlaceholder" for="file-ip-1">Select Image</label>
            <input name="pfpImage" type="file" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
            <div class="preview text-break">
              <img id="file-ip-1-preview">
              <p id="fileName"></p>
            </div>
          </div>
          <input value="Upload" name="pfp" type="submit" class="btn btn-upload-image mb-3 btn-outline-primary">

          <hr />

          <div class="input-group mb-3">
            <input autocomplete="off" type="text" name="name" class="p-3 py-4 form-control" placeholder="Change name" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <span class="p-0 input-group-text" id="basic-addon2"><button class="btn" type="submit" name="change-name"><i class="bi bi-pencil-square"></i></button></span>
            </div>
          </div>

          <hr />

          <div class="input-group mb-3">
            <input autocomplete="off" type="email" name="email" class="p-3 py-4 form-control" placeholder="Change email" aria-label="Recipient's username" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <span class="p-0 input-group-text" id="basic-addon2"><button class="btn" type="submit" name="change-email"><i class="bi bi-pencil-square"></i></button></span>
            </div>
          </div>

          <hr />

          <div class="input-group mb-3">
            <input autocomplete="off" type="text" name="pass" class="form-control" placeholder="Change password">
            <input autocomplete="off" type="text" name="cpass" class="form-control" placeholder="Confirm password">
          </div>
          <input value="Change Password" name="change-password" type="submit" class="btn btn-upload-image mb-3 btn-outline-primary">

        </div>

      </div>
      <!-- <input value="Submit everything at once!" class="btn my-0 btn-secondary btn-block" type="submit" name="submit-post"> -->


    </form>



  </div>
  <form class="d-flex justify-content-center text-center" method="post">

    <button class="btn px-5 mb-5 text-center btn-danger delete-acc-btn" type="submit" name="delete-acc">Delete your account (No confirmation)</button>
  </form>
  <?php include("../footer.php") ?>
  <script>
    function showPreview(event) {
      if (event.target.files.length > 0) {
        var src = URL.createObjectURL(event.target.files[0]);
        var preview = document.getElementById("file-ip-1-preview");
        preview.src = src;
        preview.style.display = "inline-block";
        var filename = document.getElementById('file-ip-1').files[0].name;


        let ele = document.getElementById('fileName');
        ele.innerHTML = filename;
        let ele2 = document.getElementById('fileInputPlaceholder');
        ele2.innerHTML = "Selected an Image";

      }
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>
</html>