<?php
  $server = "us-cdbr-iron-east-01.cleardb.net";
    $username = "bde5ae12f51085";
    $password = "3c146dba";
    $db = "heroku_4535866affeb67f";
    $conn = new mysqli($server, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    mysqli_query($conn, "SET NAMES utf8");
