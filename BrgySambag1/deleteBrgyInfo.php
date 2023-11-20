<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $query = "DELETE FROM tblpopulation WHERE PopID = '$id'";
    if (mysqli_query($conn, $query)) {
        header("location: brgyInfoDtb.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>
