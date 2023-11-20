<?php
    //checking database connection
    require 'connection.php';
    include 'checkuser.php';

    $token = $_GET['token'];

    //delete all the tokens that has expired
    $DateTime = new DateTime();
    $modified = $DateTime->modify('-90 seconds');
    $time = $DateTime->format('Y-m-d H:i:s');

    $deletesql = "DELETE FROM tbltoken WHERE expiration < '$time'";
    $deletequery = mysqli_query($conn, $deletesql);

    $sql = "SELECT * FROM tbltoken WHERE token = '$token'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($query);

    $userID = $result['userID'];

    $sql2 = "UPDATE users SET `verified`= '1' WHERE id = $userID";
    if(mysqli_query($conn, $sql2)){
        $deletesql = "DELETE FROM tbltoken WHERE token = '$token'";
        $deletequery = mysqli_query($conn, $deletesql);
        echo "<script>alert('Account verified');
          window.location.href='index.php';</script>";
      }else{
        echo "<script>alert('Something went wrong');
          window.location.href='index.php';</script>";
      }
?>