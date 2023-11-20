<?php
require 'connection.php';
require 'checkuser.php';
$id = $_SESSION['id'];

if(isset($_POST["submit"])){
  $commName = $_POST["commName"];
  $img = $_FILES['image']['name'];
  move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $img);

  $sql = "SELECT * FROM tblcomm WHERE `CommName` = '$commName'";
  $result = mysqli_query($conn, $sql);
  $rowcount = mysqli_num_rows($result);
  
  if($rowcount>0){
    echo"<script> alert('This Committee Already Exists'); </script>";
  }else{
    $query = "INSERT INTO tblcomm VALUES('', '$commName', '$img')";
    mysqli_query($conn, $query);
    echo"<script> alert('Committee added successfully!');
      window.location.href='committee.php' </script>";
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
      <h2 class="text-primary mb-1 font-xl">Add Committee</h2>
        <form method="POST" enctype="multipart/form-data">
          <label> Committee Name:</label>
            <input type="text" name="commName" class="address" required><br>
          <label>Profile Picture:</label>
            <input type="file" name="image" onchange="fileChanged(this)" accept=".jpg,.png"><br>
            <span  id="file"></span><br>
          <button type="submit" name="submit"> +ADD COMMITTEE </button>
        </form>
        <a href="committee.php"> Back </a>
    </div>
  </div>
<?php include 'nav/footer.php'; ?>

</body>

<script type="text/javascript">
  function fileChanged(input) {
    let fileName = document.getElementById('file');
    fileName.textContent = input.files[0]['name'];
  }
</script>

</html>

