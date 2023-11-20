<?php
    require 'connection.php';
    require 'checkuser.php';
    $Commid = $_GET["id"];

    $sql = "SELECT * FROM tblcomm WHERE CommID = '$Commid';";
    $result = mysqli_query($conn, $sql);
    $comm = mysqli_fetch_array($result, MYSQLI_ASSOC);

    //setting variables
    $commName = $comm["CommName"];

    //update function
    if(isset($_POST["submit"])){
        //updated data
        $newName = $_POST["commName"];
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $img);

        $sql = "UPDATE tblcomm SET `CommName`= '$newName', `CommPic`= '$img' WHERE CommID =".$Commid;
        if($result = mysqli_query($conn, $sql)){
            echo "<script> alert('Document Updated')
                window.location.href='committee.php'
                </script>";
        }else {
            echo "Something went wrong. Please try again later.";
       }}
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
<div class="regContainer">
    <div class="register">
      <h1>EDIT</h1>
        <form method="POST" enctype="multipart/form-data">
        <label for="lastname"> Name:</label>
          <input type="text" name="commName" value="<?php echo $commName?>" placeholder="Last Name" class="address" required><br>
        <label>Profile Picture:</label>
            <input type="file" name="image" onchange="fileChanged(this)" accept=".jpg,.png"><br>
            <span  id="file"></span><br>
        <button type="submit" name="submit"> UPDATE </button><br>
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