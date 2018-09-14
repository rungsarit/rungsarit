<?php
  $server = "us-cdbr-iron-east-01.cleardb.net";
    $username = "bde42c9156a905";
    $password = "0ba833ce";
    $db = "heroku_ad94462b3f7f2f2";
    $conn = new mysqli($server, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_query($conn, "SET NAMES utf8");
