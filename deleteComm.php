<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $query = "DELETE FROM tblcomm WHERE CommID = '$id'";
    if (mysqli_query($conn, $query)) {
        header("location: committee.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>