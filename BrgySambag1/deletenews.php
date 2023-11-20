<?php
    require_once "connection.php";
    $uploadid = $_GET["id"];
    $query = "DELETE FROM uploads WHERE uploadid = '$uploadid'";
    if (mysqli_query($conn, $query)) {
        header("location: news.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>