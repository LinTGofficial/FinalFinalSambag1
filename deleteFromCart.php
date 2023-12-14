<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $query = "DELETE FROM tbldocreqcart WHERE cartID = '$id'";
    if (mysqli_query($conn, $query)) {
        header("location: docreq.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>