<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $query = "DELETE FROM tblbrgycontact WHERE BrgyContactID = '$id'";
    if (mysqli_query($conn, $query)) {
        header("location: contactDtb.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>