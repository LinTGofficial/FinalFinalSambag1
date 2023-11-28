<?php 
//checking database connection
require 'connection.php';
include 'checkuser.php';

//delete all the tokens that has expired
$DateTime = new DateTime();
$modified = $DateTime->modify('-90 seconds');
$time = $DateTime->format('Y-m-d H:i:s');

$deletesql = "DELETE FROM tbltoken WHERE expiration < '$time'";
$deletequery = mysqli_query($conn, $deletesql);

$token = $_GET['token'];

$sql = "SELECT * FROM tbltoken WHERE token = '$token'";
$query = mysqli_query($conn, $sql);
$result = mysqli_fetch_array($query);

$userID = $result['userID'];

$rowcount = mysqli_num_rows($query);
if($rowcount != 1){
  echo "<script>alert('This link has expired');
    window.location.href='index.php';</script>";
}

if(isset($_POST["submit"])){
  $newpass = $_POST['pass'];

  $sql2 = "UPDATE users SET `password`= md5('$newpass') WHERE id = $userID";
  if(mysqli_query($conn, $sql2)){
    $deletesql = "DELETE FROM tbltoken WHERE token = '$token'";
    $deletequery = mysqli_query($conn, $deletesql);
    echo "<script>alert('Password changed successfully');
      window.location.href='login.php';</script>";
  }else{
    echo "<script>alert('Something went wrong');
      window.location.href='index.php';</script>";
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
  <a href="index.php" class='backArrow'>
    <img src='drawable/backArrow.png' alt='back'>
  </a>
  <img src='drawable/Logo.png' alt='img'  class='reg-logo'>
<div class="regContainer">
    <div class="register">
        <form method="POST">
          <div class="reg-inputs">
            <label for="email">Enter a new password:</label>
            <input type="password" name="pass" id="password" required><br>
            <input type="checkbox" onclick="myFunction()" id="showpass"> Show Password </input>
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
            <input type="password" name="confirmpass" placeholder="Re-enter Password" required><br>
            
            <button type="submit" name="submit" class="btn_primary"> Reset Password </button><br>
          </div>
        </form>
    </div>
</div>

<?php include 'nav/footer.php'; ?>

</body>
</html>