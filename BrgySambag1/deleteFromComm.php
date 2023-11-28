<?php
    require_once "connection.php";
    $id = $_GET["id"];
    $offCommId = $_GET["offCommId"];
    $query = "DELETE FROM tblofficialcom WHERE OfficialCommID = '$offCommId'";
    if (mysqli_query($conn, $query)) {
        header("location: viewOfficial.php?id=" . $id);
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>