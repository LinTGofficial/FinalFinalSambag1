<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $query = "DELETE FROM users WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        header("location: database.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>
