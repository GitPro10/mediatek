<?php
session_start();
if (isset($_SESSION["logged"]) && $_SESSION["logged"]==true) {
  session_destroy();
  header("location: http://localhost:8000/");
} else {
  header("location: http://localhost:8000/");
}