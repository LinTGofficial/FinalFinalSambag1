<?php
    require_once "connection.php";
    $uploadid = $_GET["id"];
    $query = "DELETE FROM article WHERE uploadid = '$uploadid'";
    if (mysqli_query($conn, $query)) {
        header("location: news.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>