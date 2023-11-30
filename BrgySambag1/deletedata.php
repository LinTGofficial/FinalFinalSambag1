<?php
    require_once "connection.php";
    $userId = $_GET["id"];
    $query = "UPDATE users SET `Archive` = 1 WHERE `id` = '$userId'";
    if (mysqli_query($conn, $query)) {
        header("location: adminDtb.php");
        die;
    } else {
        echo "<script> alert('Something went wrong...');
            history.go(-1);</script>";
    }
?>
