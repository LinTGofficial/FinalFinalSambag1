<?php
require 'connection.php';
require 'checkuser.php';
$id = $_SESSION['id'];

if(isset($_POST["submit"])){
  $documentName = $_POST["documentName"];
  $price = $_POST["price"];

  //checking if username is already taken
  $sql = "SELECT * FROM tbldocument WHERE `docName` = '$documentName'";
  $result = mysqli_query($conn, $sql);
  $rowcount = mysqli_num_rows($result);
  
  //preventing similar usernames
  if($rowcount>0){
    echo"<script> alert('username is already taken'); </script>";
  }else{
    $query = "INSERT INTO tbldocument VALUES('', '$documentName', $price, 0)";
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
    <h2 class="text-primary mb-1 font-xl">Add Document</h2>
        <form method="POST">
          <label for="documentName"> Document Name:</label>
          <input type="text" name="documentName" required><br>
          <label for="price"> Price:</label>
          <input type="number" name="price" placeholder="0" required><br>
          <button class="text-white btn-primary" type="submit" name="submit">Add</button>
        </form>
        <a href="documentDtb.php"> Back </a>
    </div>
  </div>
<?php include 'nav/footer.php'; ?>

</body>
</html>
