<nav class="shadow navbar navbar-expand-lg navbar-light bg-light">

  <a class="fw-bold navbar-brand" href="/">
    MediaTek
    <!--<img src="/images/logotmp.png" height="30" alt="Brand Logo">-->
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="mx-4 nav-link" href="/">News Feed</a>
      <hr class="mx-4 my-1">

      <!-- <div class="dropdown">
              <a class="mx-4 nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Latest Posts
              </a>
              <div class="mb-2 flex-wrap dropdown-menu" aria-labelledby="#navbarDropdownMenuLink">
                <?php
      /*include("../database.php");
          $latestPostsSql = "SELECT * FROM `posts` LIMIT 5";
          $latestPostsQuery = mysqli_query($conn, $latestPostsSql);

          while ($posts = mysqli_fetch_assoc($latestPostsQuery)) {

            $sliced = substr($posts["title"], 0, 60)."...";
            echo('<a class="dropdown-item" href="full-post?id='.$posts["post-id"].'">'.$sliced.'</a>');
          }*/
      ?>
              </div>
            </div>
            <hr class="mx-4 my-1">-->
      <?php
      if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
        echo('
        <div class="dropdown">
        <a class="mx-4 nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Account Management
      </a>
      <div class="mb-2 dropdown-menu" aria-labelledby="#navbarDropdownMenuLink2">
        <!--<a class="dropdown-item" href="/myposts">Your Posts </a>-->
        <a class="dropdown-item" href="profile?id='.$_SESSION["authorid"].'">Your profile</a>
        <a class="dropdown-item" href="/publish">Publish Post</a>
        <div class="dropdown-divider bg-danger"></div>
        <a class="dropdown-item" href="/logout">Log Out</a>
      </div>
      </div>
  ');
      } else {
        echo('<a class="mx-4 nav-link" href="/signup">Join Community</a>');
      }
      ?>


      <hr class="mx-4 my-1">
      <form action="/search" class="form-inline mx-4 mt-3" method="get">
        <input required autocomplete="off" name="keyword" class="form-control mr-sm-2" type="search" placeholder="Search post..." aria-label="Search">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>