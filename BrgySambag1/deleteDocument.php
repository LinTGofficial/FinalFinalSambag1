<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $query = "UPDATE tbldocument SET `Archive` = 1 WHERE `docID` = '$id'";
    if (mysqli_query($conn, $query)) {
        header("location: documentDtb.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>