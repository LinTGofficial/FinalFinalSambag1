<?php
    require 'connection.php';
    $id = $_GET["id"];
    $ref = $_GET["ref"];

    $query = "UPDATE docreq SET `status`='approved' WHERE docreqID = '$id'";
    if (mysqli_query($conn, $query)) {
        header("location: docreqByRefDtb.php?id=$ref");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>