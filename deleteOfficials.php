<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $query = "DELETE FROM tblofficials WHERE OfficialID = '$id'";

    if (mysqli_query($conn, $query)) {
        header("location: officials.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>