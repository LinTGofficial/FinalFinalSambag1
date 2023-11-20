<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $ref = $_GET["ref"];
    
    $query = "DELETE FROM docreq WHERE docreqID = '$id'";
    if (mysqli_query($conn, $query)) {
        header("location: docreqByRefDtb.php?id=$ref");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>