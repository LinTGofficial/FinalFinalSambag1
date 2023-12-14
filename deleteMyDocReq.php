<?php
    require_once "connection.php";
    $Ref = $_GET["id"];
    $query = "UPDATE docreq SET `Archive` = 1 WHERE `docreqID` = '$Ref'";
    if (mysqli_query($conn, $query)) {
        header("location: myDocReq.php");
        die;
    } else {
         echo "Something went wrong. Please try again later.";
    }
?>