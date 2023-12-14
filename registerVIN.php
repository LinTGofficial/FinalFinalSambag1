<?php
    require 'connection.php';
    include 'checkuser.php';

    if(isset($_POST['submit'])){
        $vin = $_POST['vin'];

        $sql = "SELECT * FROM tblresidents WHERE VIN = '$vin' AND archive = 0";
        $query = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($query);
        if($count == 0){
            echo "<script> alert('The VIN entered is not a registered voter in this barangay, please visit the barangay hall for more info...');
                history.go(-1);</script>";
        } else if($count > 1){
            echo "<script> alert('The VIN entered is already registered');
                history.go(-1);</script>";
        } else {
            $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
            $residentID = $result['residentID'];
            $checksql = "SELECT * FROM users WHERE residentID = '$residentID'";
            $checkquery = mysqli_query($conn, $checksql);
            $checkcount = mysqli_num_rows($checkquery);

            if($checkcount >= 1 ){
                echo "<script> alert('The VIN entered is already registered, please visit the barangay hall for more info...');
                    history.go(-1);</script>";
            } else {
                $_SESSION['vin'] = $vin;
                echo "<script>window.location.href='register.php?res=$residentID';</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="regContainer">
    <div class="m-4 register">
    <a href="index.php">
    <img src='drawable/Logo.png' alt='img'  class='reg-logo'>
    </a>
      <h2 class="text-primary font-xl">ENTER YOUR VIN</h2>
        <form method="POST">
            <label for="vin"></label>
            <input class="mb-1 font-lg" type="text" name="vin" placeholder="0000" required><br>
            <button class="btn-primary text-white" type="submit" name="submit"> PROCEED >> </button>
            <p> Already Registered? <a href="login.php"> Login here </a></p>
        </form>
    </div>
  </div>
</body>
</html>