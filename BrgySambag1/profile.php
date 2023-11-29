<?php 
//ignoring warnings about session already started
error_reporting(E_ERROR | E_PARSE);

//checking database connection
require 'connection.php';
require 'checkuser.php';
session_start();

if($_SESSION['loggedin']){
  $id = $_SESSION['id'];
  $verifysql = "SELECT * FROM users WHERE `id` = '$id'";
  $verifyresult = mysqli_query($conn, $verifysql);
  $result = mysqli_fetch_array($verifyresult);
  if($result["verified"] == "1"){

  }else{
    echo "<script>window.location.href='notverified.php?id=$id';</script>";
  }
}else{ 
  header('Location: login.php');
}

$id = $_SESSION['id'];

$sql = "SELECT * FROM users WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$acc = mysqli_fetch_array($result, MYSQLI_ASSOC);

$name = $acc['firstname'] . ' ' . $acc['middleName'] . ' ' . $acc['lastname'];
$birthdate = $acc['birthdate'];
$city = $acc['city'];
$barangay = $acc['barangay'];
$sitio = $acc['sitio'];
$houseNo = $acc['houseNo'];
$street = $acc['street'];
$username = $acc['username'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Registration</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <!-- <link rel="stylesheet" type="text/css" hresf="style.css"> -->
</head>
<body>
<!-- <?php include 'topnavs/topnavLoggedIn.html'?> -->
<div class="mt-2 regContainer">
    <h1 class="abt-header">MY PROFILE</h1>
    <div class="mt-10 pt-4 about-brgy">
      <div class="about-ins">
        <div>
          <p>Account Id:</p>
          <p>Name:</p>
          <p>City:</p>
          <p>Barangay:</p>
          <p>Sitio:</p>
          <p>House No.:</p>
          <p>Street:</p>
        </div>
        <div>
          <p><?php echo "$id"?></p>
          <p><?php echo "$name"?></p>
          <p><?php echo "$city"?></p>
          <p><?php echo "$barangay"?></p>
          <p><?php echo "$sitio"?></p>
          <p><?php echo "$houseNo"?></p>
          <p><?php echo "$street"?></p>
        </div>
      </div>
      <div>
        <a href="updateprofile.php?id=<?php echo $id; ?>" class="btn_primary"> Edit Profile </a>
        <a href="updatepassword.php?id=<?php echo $id; ?>" class="btn_primary"> Change Password </a>
      </div>
      <div>

      </div>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>