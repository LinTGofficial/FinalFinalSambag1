<?php 
//ignoring warnings about session already started
error_reporting(E_ERROR | E_PARSE);

//checking database connection
require 'connection.php';
require 'checkuser.php';
session_start();

if($_SESSION['loggedin']){
  $id = $_SESSION['id'];
}else{ 
  header('Location: login.php');
}

$id = $_SESSION['id'];

$sql = "SELECT * FROM users u JOIN tblresidents r ON u.residentID = r.residentID WHERE userID = '$id'";
$result = mysqli_query($conn, $sql);
$acc = mysqli_fetch_array($result, MYSQLI_ASSOC);

$name = $acc['fName'] . ' ' . $acc['mName'] . ' ' . $acc['lName'];
$birthdate = $acc['birthdate'];
$sitio = $acc['sitio'];
$houseNo = $acc['houseNo_Street'];
$email = $acc['email'];
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
    <div class="mt-2 pt-4 about-brgy">
      <div class="about-ins">
        <div>
          <p>Account Id</p>
          <p>Name</p>
          <p>Address</p>
          <p>Email</p>
        </div>
        <div>
          <p>: <?php echo "$id"?></p>
          <p>: <?php echo "$name"?></p>
          <p>: <?php echo "$sitio"?>, <?php echo "$houseNo"?></p>
          <p>: <?php echo "$email"?></p>
        </div>
      </div>
      <div>
        <a href="updateprofile.php?id=<?php echo $id; ?>" class="btn_primary"> Change Email </a>
        <a href="updatepassword.php?id=<?php echo $id; ?>" class="btn_primary"> Change Password </a>
      </div>
      <div>

      </div>
    </div>
</div>
<?php include 'nav/footer.php'; ?>

</body>
</html>