<?php
    require_once "connection.php";
    $id = $_GET["id"];

    $sql = "SELECT * FROM tblbrgycontact WHERE displayed = 1";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if($count < 2){
        $query = "UPDATE tblbrgycontact SET `displayed` = 1 WHERE BrgyContactID = '$id'";
        if (mysqli_query($conn, $query)) {
            header("location: contactDtb.php");
            die;
        } else {
             echo "Something went wrong. Please try again later.";
        }
    } else {?>
        <script>
            alert("Only 2 can be displayed, uncheck others to display the selected contact")
            window.location.href = "contactDtb.php"
        </script>
    <?php }
?>