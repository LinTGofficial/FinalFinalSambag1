<?php
    require_once "connection.php";
    $id = $_GET["id"];

    $sql = "UPDATE tblbrgycontact SET `displayed` = 0 WHERE BrgyContactID = '$id'";
    if(mysqli_query($conn, $sql)){
        header("Location: contactDtb.php");
    }
?>