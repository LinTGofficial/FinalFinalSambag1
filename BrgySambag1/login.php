<?php 
//checking database connection
require 'connection.php';
include 'checkuser.php';
session_destroy();

if(isset($_POST["submit"])){

  $email = $_POST["email"];
  $pass = $_POST["pass"];

  //Look for user
  $sql = ("SELECT * FROM users u JOIN tblresidents r ON  u.residentID = r.residentID WHERE u.email='$email' AND r.archive = 0 AND u.Archive = 0");
  $result = mysqli_query($conn, $sql);
  $acc = mysqli_fetch_array($result, MYSQLI_ASSOC);
  if($email){
    if(md5($pass) == $acc["password"]){
      session_start();

      //setting users important datas
      $_SESSION['loggedin'] = true;
      $_SESSION['username'] = $username;
      $_SESSION['name'] = $acc['firstname'] . " " . $acc['lastname'];
      $_SESSION['birthdate'] = $acc['birthdate'];
      $_SESSION['sitio'] = $acc['sitio'];
      $_SESSION['houseNo'] = $acc['houseNo'];
      $_SESSION['id'] = $acc["userID"];
      $_SESSION['email'] = $acc["email"];
      $_SESSION['privilege'] = $acc["isAdmin"];
      $_SESSION['verified'] = $acc["verified"];
      echo"<script> alert('Successfully Logged In') </script> ";
      header("Location: index.php");
      die;
    }else{
      echo"<script> alert('Email or Password is not correct') 
        window.location.href='login.php'</script> ";
    }
  }
  else{
    echo"<script> alert('Email or Password is not correct') 
      window.location.href='login.php'</script> ";
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
    <div class="register mt-3">
    <a href="index.php">
    <img src='drawable/Logo.png' alt='img'  class='reg-logo'>
    </a>
        <form method="POST">
          <div class="m-2">
            <input class="mb-1 font-lg" type="text" name="email" placeholder="Email" required><br>
            <input class="mb-1 font-lg" type="password" name="pass" placeholder="Password" id="password" required><br>
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
            <a class="text-primary" style="float:right" href="forgotPass.php">Forgot Password?</a>
          </div>
          <button class="btn-primary text-white" type="submit" name="submit"> Log In </button><br>
          <p> Not yet registered? <a href="registerVIN.php"> REGISTER HERE </a></p>
        </form>
    </div>
</div>

</body>
</html>