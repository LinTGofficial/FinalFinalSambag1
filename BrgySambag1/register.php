<?php
session_start();
//checking connection
require 'connection.php';
include 'checkuser.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

//for phpmailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
include 'PHPMailer-master/mailer.php';

if(isset($_POST["submit"])){
  $lastname = $_POST["lastname"];
  $middlename = $_POST["middlename"];
  $firstname = $_POST["firstname"];
  $age = $_POST["age"];
  $city = $_POST["city"];
  $barangay = $_POST["barangay"];
  $sitio = $_POST["sitio"];
  $houseNo = $_POST["houseNo"];
  $street = $_POST["street"];
  $privilege = 0;
  
  $email = trim($_POST["email"]);
  $password = $_POST["pass"];

  //checking username and email is already taken
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);
  $rowcount = mysqli_num_rows($result);
  
  if($rowcount > 0){
    echo"<script> alert('Email is already taken'); </script>";
  }else{
    if($_POST["pass"] === $_POST["confirmpass"]){
      if(strlen($password) >= 8){
        if($age >= 18){
          $sql = "INSERT INTO users VALUES('', '$lastname', '$middlename', '$firstname', '$city', '$barangay', '$sitio', '$houseNo', '$street', '$age', '$email' , MD5('$password'), $privilege, '0')";
          mysqli_query($conn, $sql);
    
          $sql2 = "SELECT * FROM users WHERE email = '$email'";
          $query = mysqli_query($conn, $sql2);
          $result = mysqli_fetch_assoc($query);
          $userID = $result['id'];
          $_SESSION['email'] = $email;
          $token = md5(generateToken());
          $dateTime = new DateTime();
          $dateTime->modify('+90 seconds');
          $expiration = $dateTime->format('Y-m-d H:i:s');
    
          $mail->addAddress($email, $email);
          $mail->Body = "Click this link to verify your account: <a href='localhost/brgysambag1/verify.php?token=$token'>CLICK HERE</a>";
      
          $tokenSql = "INSERT INTO tbltoken values('', '$userID', '$token', '$expiration')";
            if (mysqli_query($conn, $tokenSql) && $mail->send()) {
              echo"<script> alert('Check email to complete Registration'); 
              window.location.href='login.php'</script>";
            } else {
              echo "<script> alert('Email was not sent: $mail->ErrorInfo');
              window.location.href='login.php';</script>;";
            }
          }else{
            echo"<script> alert('You must be 18+ to register');
            window.location.href='login.php';</script>";
          }

        }else{
          echo"<script> alert('Password must be at least 8 characters long')
          window.location.href='login.php';</script>";
        }
      }
      else {
        echo"<script> alert('Password and Confirm Password did not match')
        window.location.href='login.php'; </script>";
      }
    }
  }

function generateToken(){
  $genToken = bin2hex(random_bytes(16));
  return $genToken;
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
          <input class="mb-1 font-lg" type="text" name="firstname" placeholder="First Name" class="address" required><br>
          <input class="mb-1 font-lg" type="text" name="middlename" placeholder="Middle Name" class="address"><br>
          <input class="mb-3 font-lg" type="number" name="age" placeholder="Age" required><br>
          <label for="lastname"> Address:</label>
          <input class="mb-1 font-lg" type="text" name="city" placeholder="City" class="address" required><br>
          <input class="mb-1 font-lg" type="text" name="barangay" placeholder="Barangay" class="address" required><br>
          <input class="mb-1 font-lg" type="text" name="sitio" placeholder="Sitio" class="address" required><br>
          <input class="mb-1 font-lg" type="text" name="houseNo" placeholder="House No." class="address" required><br>
          <input class="mb-3 font-lg" type="text" name="street" placeholder="Street" class="address" required><br>
          <label class="mb-1 font-lg" for="username"> Account: </label>
          <input class="mb-1 font-lg" type="text" name="email" placeholder="Email" class="address" required><br>
          <input class="mb-1 font-lg" type="password" name="pass" placeholder="Password" id="password" class="address" required><br>
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
