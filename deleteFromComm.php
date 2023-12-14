<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $offCommId = $_GET["offCommId"];
    $query = "DELETE FROM tblofficialcom WHERE OfficialCommID = '$offCommId'";
    if (mysqli_query($conn, $query)) {
        echo "<script>window.history.back();</script>";
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>