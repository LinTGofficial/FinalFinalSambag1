<?php
    require_once "connection.php";
    $resId = $_GET["id"];
    $query = "UPDATE tblresidents SET `Archive` = 1 WHERE `residentID` = '$resId'";
    if (mysqli_query($conn, $query)) {
        header("location: residentsDtb.php");
        die;
    } else {
        echo "<script> alert('Something went wrong...');
            history.go(-1);</script>";
    }
?>
