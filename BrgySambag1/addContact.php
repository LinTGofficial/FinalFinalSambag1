<?php
require 'connection.php';

//for ignoring warning about session
error_reporting(E_ERROR | E_PARSE);
session_start();

if(!$_SESSION['privilege']){
  header("Location: index.php");
  die;
}else{
  include 'checkuser.php';
}

if(isset($_POST["submit"])){
  $name = $_POST["name"];
  $contact = $_POST["contactInfo"];

  //checking if name is already taken
  $sql = "SELECT * FROM tblbrgycontact WHERE `ContactName` = '$name'";
  $result = mysqli_query($conn, $sql);
  $rowcount = mysqli_num_rows($result);
  
  //preventing similar usernames
  if($rowcount>0){
    echo"<script> alert('username is already taken'); </script>";
  }else{
    $query = "INSERT INTO tblbrgycontact VALUES('', '$name', '$contact', 0)";
    mysqli_query($conn, $query);
    echo"<script> alert('Document added successfully!'); </script>";
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
    <div class="register">
    <h2 class="text-primary mb-1 font-xl">Add Contact Information</h2>
        <form method="POST">
          <label for="documentName">Name:</label>
            <input type="text" name="name" required><br>
          <label for="contact">Contact No./Info.:</label>
            <input type="text" name="contactInfo" required><br>
          <button type="submit" name="submit"> SUBMIT </button>
        </form>
        <a href="contactDtb.php"> Back </a>
    </div>
  </div>
<?php include 'nav/footer.php'; ?>
</body>
</html>
