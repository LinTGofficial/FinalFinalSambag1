<?php
session_start();
require 'connection.php';
include 'checkuser.php';

$vin = $_SESSION['vin'];

if(is_null($vin)){
  echo"<script>window.location.href='login.php'</script>";
}

if(isset($_POST["submit"])){
  $lastname = trim($_POST["lastname"]);
  $middlename = trim($_POST["middlename"]);
  $firstname = trim($_POST["firstname"]);
  $privilege = 0;
  
  $email = trim($_POST["email"]);
  $password = $_POST["pass"];

  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);
  $rowcount = mysqli_num_rows($result);
  
  if($rowcount > 0){
    echo"<script> alert('Email is already taken');
      history.go(-1); </script>";
  }else{
    $checksql = "SELECT * FROM tblresidents WHERE VIN = '$vin' AND lName = '$lastname' AND mName = '$middlename' AND fName = '$firstname'";
    $checkresult = mysqli_query($conn, $checksql);
    $check = mysqli_fetch_array($checkresult, MYSQLI_ASSOC);
    $residentID = $check['residentID'];
    $checkcount = mysqli_num_rows($checkresult);
    if($checkcount == 0){
      echo"<script> alert('name is incorrect');
        history.go(-1); </script>";
    } else {
      if($_POST["pass"] === $_POST["confirmpass"]){
        if(strlen($password) >= 8){
            //successfull registration
            $sql = "INSERT INTO users VALUES('', '$residentID', '$email' , MD5('$password'), $privilege, 0)";
              if (mysqli_query($conn, $sql)) {
                echo"<script> alert('Registration Complete!');
                  window.location.href='login.php';</script>";
              } else {
                echo "<script> alert('Email was not sent: $mail->ErrorInfo');
                history.go(-1);</script>;";
              }
  
          }else{
            echo"<script> alert('Password must be at least 8 characters long')
            history.go(-1);</script>";
          }
        }
        else {
          echo"<script> alert('Password did not match')
          history.go(-1); </script>";
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <!-- <link rel="stylesheet" type="text/css" hresf="style.css"> -->
</head>
<body>
  <div class="regContainer">
    <div class="m-4 register">
    <a href="index.php">
    <img src='drawable/Logo.png' alt='img'  class='reg-logo'>
    </a>
      <h2 class="text-primary font-xl">User Registration</h2>
        <form method="POST">
          <label for="lastname"> Name:</label>
          <input class="mb-1 font-lg" type="text" name="lastname" placeholder="Last Name" class="address" required><br>
          <input class="mb-1 font-lg" type="text" name="middlename" placeholder="Middle Name" class="address"><br>
          <input class="mb-1 font-lg" type="text" name="firstname" placeholder="First Name" class="address" required><br>
          <label class="font-lg" for="username"> Account: </label>
          <input class="mb-1 font-lg" type="text" name="email" placeholder="Email" class="address" required><br>
          <input class="font-lg" type="password" name="pass" placeholder="Password" id="password" class="address" required><br>
          <input class="mb-1 font-lg" type="checkbox" onclick="myFunction()" id="showpass"> Show Password </input>
          <script>
            function myFunction() {
              var x = document.getElementById("password");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
          </script>
          <label for="confirmpass"> Confirm Password: </label>
          <input class="mb-3 font-lg" type="password" name="confirmpass" placeholder="Re-enter Password" class="address" required><br>
          <button class="btn-primary text-white" type="submit" name="submit"> Register </button>
          <p> Already Registered? <a href="login.php"> Login here </a></p>
        </form>
    </div>
  </div>

</body>
</html>
